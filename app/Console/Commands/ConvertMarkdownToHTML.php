<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ConvertMarkdownToHTML extends Command
{
    protected $signature = 'convert:markdown-to-html';
    protected $description = 'Convert markdown to structured HTML';

    public function handle()
    {
        
        $docURL = "https://docs.google.com/document/d/1e8Dv53JpKk2POP5HXfyTl_raELORQG7gF-NlT1kPQOc/export?format=md";
        $response = Http::get($docURL);

        if($response->successful()) {
            $content = $response->body();
        } else {
            $this->error('Failed to fetch the markdown content.');
            return;
        }
        
        

        $html = '';

        // Remove everything before and including "overview document"
        $content = preg_replace('/^.*?overview document\s*/is', '', $content);

        // Remove everything after and including "Stats, assuming the"
        $content = preg_replace('/Stats, assuming the.*$/is', '', $content);

        // Remove any instances of "**Total time for section:** X hours, Y mins"
        $content = preg_replace('/\*\*Total time for section:\*\*\s*\d+\s*hours?,\s*\d+\s*mins?/i', '', $content);

        $content = str_replace([
            '**GP stack after step:**',
            '**Items needed during step:**',
            '**Skills/quests met to do step?:**',
            '**Total time taken during step:**'
        ], [
            '**GP stack:**',
            '**Items needed:**',
            '**Skills/quests met?:**',
            'Total time:'
        ], $content);

        /* Match sections using the pattern for section headers and the total time at the end
        preg_match_all('/(\d+\..*?)(GP stack:.*?Items needed:.*?Total time:.*?)(?=\n\d+\.|\z)/s', $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $html .= $this->processSection($match);
        } */

        // Match section titles
        preg_match_all('/##\s*\*\*(\d+\.\d+:\s*.*?)\*\*/', $content, $titleMatches, PREG_OFFSET_CAPTURE);

        // Match regular sections
        preg_match_all('/(\d+\..*?)(GP stack:.*?Items needed:.*?Total time:.*?)(?=\n\d+\.|\z)/s', $content, $sectionMatches, PREG_OFFSET_CAPTURE);

        // Combine and sort matches based on their positions in the content
        $allMatches = array_merge($titleMatches[0], $sectionMatches[0]);
        usort($allMatches, function($a, $b) {
            return $a[1] <=> $b[1];
        });

        foreach ($allMatches as $index => $match) {
            if (strpos($match[0], '##') === 0) {
                $html .= $this->processTitle($match[0]);

                if (isset($allMatches[$index + 1]) && strpos($allMatches[$index + 1][0], '##') !== 0) {
                    // Remove the title from the start of the next section content
                    $allMatches[$index + 1][0] = preg_replace('/^##\s*\*\*.*?\*\*\s*/', '', $allMatches[$index + 1][0]);
                }
            } else {
                preg_match_all('/(\d+\..*?)(GP stack:.*?Items needed:.*?Total time:.*?)(?=\n\d+\.|\z)/s', $match[0], $matches, PREG_SET_ORDER);
                $html .= $this->processSection($matches[0]);
            }
        }

        // Save the output to an HTML file
        file_put_contents(storage_path('app/public/html/output.html'), $html);

        $this->info('Conversion completed successfully!');
    }

    protected function processTitle($title)
    {
        // Extract the actual title text
        if (preg_match('/##\s*\*\*(\d+\.\d+:\s*.*?)\*\*/', $title, $match)) {
            $titleText = htmlspecialchars($match[1]);
            return "<div class=\"section-title\"><h2>{$titleText}</h2></div>\n";
        }
        return '';
    }

    protected function processSection($match)
    {
        // $match[1] is the section content
        // $match[2] is the GP stack, items needed, and total time block
    
        // Split the section into lines and process
        $lines = explode("\n", trim($match[1]));
        $sidebarContent = trim($match[2]);
    
        // Remove `Skills/quests met?:` and surrounding asterisks
        $lines = array_map(function ($line) {
            $line = preg_replace('/\*?Skills\/quests met\?\:?\*?/i', '', $line);
            return preg_replace('/^\d+\.\s*/', '', trim($line)); // Also remove any `#.` from interior steps
        }, $lines);
    
        // Filter out any empty lines or lines that only contain asterisks
        $lines = array_filter($lines, function ($line) {
            return !empty(trim($line));
        });
    
        // Sidebar processing
        $gpStack = $this->cleanMarkdown($this->extractSidebarInfo($sidebarContent, 'GP stack'));
        $itemsNeeded = $this->cleanMarkdown($this->extractSidebarInfo($sidebarContent, 'Items needed'));
        $totalTime = $this->cleanMarkdown($this->extractSidebarInfo($sidebarContent, 'Total time'));
    
        // Generate the HTML
        $html = "<div class=\"section\">\n";
        $html .= "\t<div class=\"sidebar\">\n";
        $html .= "\t\t<p><strong>GP Stack:</strong> {$gpStack}</p>\n";
        $html .= "\t\t<p><strong>Items Needed:</strong> {$itemsNeeded}</p>\n";
        $html .= "\t\t<p><strong>Total Time:</strong> {$totalTime}</p>\n";
        $html .= "\t</div>\n";
        $html .= "\t<div class=\"content\">\n";
    
        foreach ($lines as $line) {
            // Split the line into sentences for separate steps
            $sentences = preg_split('/(?<=[.?!])\s+(?=[A-Z0-9])/', $line);

            // check if the line contains Tutorial island up to and including Wintertodt
            if (strpos($line, 'Tutorial island up to and including Wintertodt') !== false) {
                continue;
            }

            // check if line contains Total time for section
            if (strpos($line, 'Total time for section') !== false) {
                continue;
            }
    
            foreach ($sentences as $sentence) {
                $stepId = uniqid('step_');
    
                // Convert markdown to HTML
                $sentence = $this->convertMarkdownToHtml($sentence);
    
                // Only add the step if it contains actual text
                if (!empty(trim(strip_tags($sentence)))) {
                    $html .= "\t\t<div class=\"step\">\n";
                    $html .= "\t\t\t<input id=\"{$stepId}\" type=\"checkbox\"/>\n";
                    $html .= "\t\t\t<label for=\"{$stepId}\">" . trim($sentence) . "</label>\n";
                    $html .= "\t\t</div>\n";
                }
            }
        }
    
        $html .= "\t</div>\n";
        $html .= "</div>\n";
    
        return $html;
    }
    

    protected function extractSidebarInfo($sidebarContent, $field)
    {
        preg_match('/' . preg_quote($field, '/') . ':\s*(.*?)$/mi', $sidebarContent, $matches);
        return $matches[1] ?? 'Unknown';
    }

    protected function cleanMarkdown($text)
    {
        // Clean up any remaining markdown syntax that might not be converted properly
        $text = str_replace('**', '', $text);
        $text = str_replace('*', '', $text);
        return $text;
    }

    protected function convertMarkdownToHtml($text)
    {
        // Convert bold **text**
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);

        // Convert italic *text*
        $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);

        // Convert links [text](url)
        $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $text);

        return $text;
    }
}
