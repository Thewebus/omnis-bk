<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <style>
        code[class*=language-], pre[class*=language-] {
            color: #000;
            background: 0 0;
            text-shadow: 0 1px #fff;
            text-align: left;
            white-space: pre;
            word-spacing: normal;
            word-break: normal;
            word-wrap: normal;
            line-height: 1.5;
            -moz-tab-size: 4;
            -o-tab-size: 4;
            tab-size: 4;
            -webkit-hyphens: none;
            -ms-hyphens: none;
            hyphens: none; 
        }

        code[class*=language-] ::-moz-selection, code[class*=language-]::-moz-selection {
            text-shadow: none;
            background: #b3d4fc; 
        }

        pre[class*=language-] ::-moz-selection, pre[class*=language-]::-moz-selection {
            text-shadow: none;
            background: #b3d4fc; 
        }

        code[class*=language-] ::-moz-selection, code[class*=language-]::-moz-selection {
            text-shadow: none;
            background: #b3d4fc; 
        }

        code[class*=language-] ::selection, code[class*=language-]::selection {
            text-shadow: none;
            background: #b3d4fc; 
        }

        pre[class*=language-] {
            padding: 1em;
            margin: .5em 0;
            overflow: auto; 
        }
        pre[class*=language-] ::-moz-selection, pre[class*=language-]::-moz-selection {
            text-shadow: none;
            background: #b3d4fc; 
        }
        pre[class*=language-] ::selection, pre[class*=language-]::selection {
            text-shadow: none;
            background: #b3d4fc; 
        }

        @media print {
        code[class*=language-], pre[class*=language-] {
            text-shadow: none; } 
        }

        :not(pre) > code[class*=language-], pre[class*=language-] {
            background: #f6f7fb; 
        }

        :not(pre) > code[class*=language-] {
            padding: .1em;
            border-radius: .3em;
            white-space: normal; 
        }

        .token.cdata, .token.comment, .token.doctype, .token.prolog {
            color: #708090; 
        }

        .token.punctuation {
            color: #999; 
        }

        .namespace {
            opacity: .7; 
        }

        .token.boolean, .token.constant, .token.deleted, .token.number, .token.property, .token.symbol, .token.tag {
            color: #905; 
        }

        .token.attr-name, .token.builtin, .token.char, .token.inserted, .token.selector, .token.string {
            color: #690; 
        }

        .language-css .token.string, .style .token.string {
            color: #a67f59;
            background: rgba(255, 255, 255, 0.5); 
        }

        .token.entity, .token.operator, .token.url {
            color: #a67f59;
            background: rgba(255, 255, 255, 0.5); 
        }

        .token.atrule, .token.attr-value, .token.keyword {
            color: #07a; 
        }

        .token.function {
            color: #DD4A68; 
        }

        .token.important, .token.regex, .token.variable {
            color: #e90; 
        }

        .token.bold, .token.important {
            font-weight: 700; 
        }

        .token.italic {
            font-style: italic; 
        }

        .token.entity {
            cursor: help; 
        }
        .code-box-copy {
            position: relative;
            font-size: 16px;
            display: none; 
        }
        .code-box-copy pre[class*="language-"] {
            border: 1px solid #dee3f9;
            border-radius: 2px; 
        }

        .code-box-copy__btn {
            opacity: 0;
            position: absolute;
            top: 11px;
            right: 11px;
            width: 36px;
            height: 36px;
            background-color: #e5eaff;
            border: 1px solid #dee3f9;
            color: #333;
            border-radius: 4px;
            -webkit-transition: all 0.25s ease-in-out;
            transition: all 0.25s ease-in-out; 
        }

        .code-box-copy:hover .code-box-copy__btn {
            opacity: 1; 
        }

        .code-box-copy__btn:disabled {
            background-color: #eee;
            border-color: #ccc;
            color: #333;
            pointer-events: none; 
        }

        .code-box-copy__btn:hover {
            cursor: pointer;
            background-color: #fff;
            border: 1px solid #ccc;
            color: #333; 
        }

        .code-box-copy__btn:focus, .code-box-copy__btn:active {
            outline: 0; 
        }

        .code-box-copy__tooltip {
            display: none;
            position: absolute;
            bottom: calc(100% + 11px);
            right: 0;
            width: 80px;
            padding: 6px 0;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            font-size: 13px; 
        }
        .code-box-copy__tooltip::after {
            display: block;
            position: absolute;
            right: 13px;
            bottom: -5px;
            content: ' ';
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 5px 5px 0 5px;
            border-color: #333 transparent transparent transparent; 
        }

        .card-body.show-source .code-box-copy {
            display: block; 
        }
    </style> --}}
    <style>
        table, tr, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <title>Scolarité</title>
</head>
<body>
    <h3>Scolarité étudiant : {{ Auth::user()->fullname }}</h3>
    <table>
        <thead>
            <tr>
                <th scope="col">N°</th>
                <th scope="col">Montant</th>
                <th scope="col">Reste</th>
                <th scope="col">Date</th>
                <th scope="col">Scolarité</th>
            </tr>
        </thead>
        <tbody>
            @if (count($scolarites) > 0)
                @foreach ($scolarites as $scolarite)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $scolarite['montant'] }}</td>
                        <td>{{ $scolarite['reste'] }}</td>
                        <td>{{ $scolarite['created_at']->format('d/m/Y') }}</td>
                        <td>{{ $scolarite['scolarite'] }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">No Data</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- <script>
        "use strict";
        $(document).ready(function() {
            var tooltip_init = {
                init: function() {
                    $("button").tooltip();
                    $("a").tooltip();
                    $("input").tooltip();
                }
            };
            tooltip_init.init()
        });


        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script> --}}
</body>
</html>

{{-- @extends('layouts.etudiant.master-pdf')

@section('content')
<div class="container-fluid grid-wrrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Scolarité étudiant : {{ Auth::user()->fullname }}</h5>
                    <span>Use class<code>.table-primary</code> inside thead tr element.</span>
                </div>
                <div class="card-block row">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Montant</th>
                                        <th scope="col">Reste</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Scolarité</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($scolarites) > 0)
                                        @foreach ($scolarites as $scolarite)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $scolarite['montant'] }}</td>
                                                <td>{{ $scolarite['reste'] }}</td>
                                                <td>{{ $scolarite['created_at']->format('d/m/Y') }}</td>
                                                <td>{{ $scolarite['scolarite'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No Data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}