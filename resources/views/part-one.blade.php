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
    </section>
</div>

@endsection