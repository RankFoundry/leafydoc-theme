<?php

namespace RankFoundry\LeafyDOC;

class Palette {

    public function __construct() {

		add_filter('kadence_global_palette_defaults', [$this, 'leafydoc_palette_defaults'], 20);
	}

    public function leafydoc_palette_defaults($palettes) {
        $palettes = '{
            "palette":[
                {
                    "color":"#91705C",
                    "slug":"palette1",
                    "name":"Palette Color 1"
                },{
                    "color":"#FBE46E",
                    "slug":"palette2",
                    "name":"Palette Color 2"
                },{
                    "color":"#092D2A",
                    "slug":"palette3",
                    "name":"Palette Color 3"
                },{
                    "color":"#FDCA85",
                    "slug":"palette4",
                    "name":"Palette Color 4"
                },{
                    "color":"#FFF9C7",
                    "slug":"palette5",
                    "name":"Palette Color 5"
                },{
                    "color":"#FBFBF4",
                    "slug":"palette6",
                    "name":"Palette Color 6"
                },{
                    "color":"#EDF2F7",
                    "slug":"palette7",
                    "name":"Palette Color 7"
                },{
                    "color":"#F7FAFC",
                    "slug":"palette8",
                    "name":"Palette Color 8"
                },{
                    "color":"#ffffff",
                    "slug":"palette9",
                    "name":"Palette Color 9"
                }
            ],
            "second-palette":[
                {
                    "color":"#dd6b20",
                    "slug":"palette1",
                    "name":"Palette Color 1"
                },{
                    "color":"#cf3033",
                    "slug":"palette2",
                    "name":"Palette Color 2"
                },{
                    "color":"#27241d",
                    "slug":"palette3",
                    "name":"Palette Color 3"
                },{
                    "color":"#423d33",
                    "slug":"palette4",
                    "name":"Palette Color 4"
                },{
                    "color":"#504a40",
                    "slug":"palette5",
                    "name":"Palette Color 5"
                },{
                    "color":"#625d52",
                    "slug":"palette6",
                    "name":"Palette Color 6"
                },{
                    "color":"#e8e6e1",
                    "slug":"palette7",
                    "name":"Palette Color 7"
                },{
                    "color":"#faf9f7",
                    "slug":"palette8",
                    "name":"Palette Color 8"
                },{
                    "color":"#ffffff",
                    "slug":"palette9",
                    "name":"Palette Color 9"
                }
            ],
            "third-palette":[
                {
                    "color":"#3296ff",
                    "slug":"palette1",
                    "name":"Palette Color 1"
                },{
                    "color":"#003174",
                    "slug":"palette2",
                    "name":"Palette Color 2"
                },{
                    "color":"#ffffff",
                    "slug":"palette3",
                    "name":"Palette Color 3"
                },{
                    "color":"#f7fafc",
                    "slug":"palette4",
                    "name":"Palette Color 4"
                },{
                    "color":"#edf2f7",
                    "slug":"palette5",
                    "name":"Palette Color 5"
                },{
                    "color":"#cbd2d9",
                    "slug":"palette6",
                    "name":"Palette Color 6"
                },{
                    "color":"#1A202C",
                    "slug":"palette7",
                    "name":"Palette Color 7"
                },{
                    "color":"#252c39",
                    "slug":"palette8",
                    "name":"Palette Color 8"
                },{
                    "color":"#2D3748",
                    "slug":"palette9",
                    "name":"Palette Color 9"
                }
            ],
            "active":"second-palette"}';
        return $palettes;
    }
}

new Palette();