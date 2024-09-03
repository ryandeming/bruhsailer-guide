@extends('layouts.app')
@php
    $htmlContent = Storage::disk('public')->get('html/part1.html');
@endphp

@section('content')
<div class="container">
    <section>
        <h1>Bruhsailer Ironman Guide: Part 1</h1>
        <h2>Chapter 1: Get to da chopper earth staves</h2>
        <p>This guide has three chapters, each of which is split into multiple sections. You can find the links to the chapters at the end of each chapter, along with a link to a sheet giving the stats and GP that you will have at each and every step. The full guide is very long and will progress your account to good stats for future progression in an efficient manner. If you are looking to start an ironman account but don’t want a very long guide, every section end(/start) is a very reasonable moment to pause your progression and divert.</p>
        <p>Written by So Iron BRUH in collaboration with ParasailerOSRS</p>
        <a target="_blank" href="https://docs.google.com/document/d/1gCez5XG5FA1kmmBYydur3RaI_cr-dYNJlnigRrByEX8" style="display: block">Original Google Doc Guide</a>
        <a target="_blank" href="https://docs.google.com/document/d/1CBkFM70SnrW4hJXvHM2F1fYCuBF_fRnEXnTYgRnRkAE/edit#heading=h.jeorbgdacn98">Original Guide Overview Google Doc</a>
    </section>
    {!! $htmlContent !!}
    <section>
        <p>Stats, assuming the guide was followed completely and you did your bird runs to 49 hunter:</p>
        <ul>
            <li>Atk: 46</li>
            <li>Str: 50</li>
            <li>Def: 34</li>
            <li>HP: 37</li>
            <li>Range: 45</li>
            <li>Pray: 43</li>
            <li>Magic: 63</li>
            <li>RC: 24</li>
            <li>Cons: 38 (more if you had over 30 after Todt)</li>
            <li>Agil: 51</li>
            <li>Herb: 40</li>
            <li>Thiev: 78 (80 if you did all arteglass)</li>
            <li>Craft: 55</li>
            <li>Fletch: 48</li>
            <li>Slay: 16</li>
            <li>Hunt: 49 (depends on the amount of bird runs you need, lower is fine)</li>
            <li>Mining: 44</li>
            <li>Smithing: 41</li>
            <li>Fish: 74</li>
            <li>Cook: 60 (estimate, if you cut-eat barb)/70 (if you do not cut-eat barb so had to do mess hall to 70)</li>
            <li>Firemaking: 89</li>
            <li>WC: 70 (or 75 if you got unlucky on Magic logs)</li>
            <li>Farming: 63 (possibly higher)</li>
        </ul>
        <a target="_blank" href="https://docs.google.com/document/d/1CBkFM70SnrW4hJXvHM2F1fYCuBF_fRnEXnTYgRnRkAE/edit#heading=h.jeorbgdacn98" style="display: block">Original Guide Overview Google Doc</a>
        <a target="_blank" href="https://docs.google.com/document/d/1gCez5XG5FA1kmmBYydur3RaI_cr-dYNJlnigRrByEX8" style="display: block">Original Part 1 Google Doc</a>
        <a target="_blank" href="https://docs.google.com/document/d/1YQiZ6curEYPpgm3DtjZcWHPoEEkGpYdXZ-I0gCM5p10" style="display: block">Original Part 2 Google Doc</a>
        <a target="_blank" href="https://docs.google.com/document/d/1O1VeAkwS6VAzGVy0GT205GqiNaOAbw17H5uyuMwz39o" style="display: block">Original Part 3 Google Doc</a>
        <a target="_blank" href="https://docs.google.com/spreadsheets/d/1XZ-3Kja7_QS4Rxj4mJXeATXHBP03lrdUSt46gO3pWHk/edit#gid=1506136399" style="display: block">Detailed Math on every step</a>
        <a target="_blank" href="https://drive.google.com/drive/folders/1mqirlAU0Pk5OGI5V8NN9BhHKIeGwG1Ea" style="display: block">Parasailers image folder</a>

    </section>
</div>

@endsection