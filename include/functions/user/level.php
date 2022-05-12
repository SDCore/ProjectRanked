<?php
    function colorPrimary($level) {
        if($level <= 100) return "#D3D3D3";
        if($level <= 200) return "#AA93D7";
        if($level <= 300) return "#7CA07A";
        if($level <= 400) return "#B3A19D";
        
        return "#82AAC4";
    }

    function colorSecondary($level) {
        if($level <= 100) return "#808080";
        if($level <= 200) return "#957FC8";
        if($level <= 300) return "#688F56";
        if($level <= 400) return "#83695C";
        
        return "#6395B8";
    }

    function colorTritary($level) {
        if($level <= 100) return "#4c4c4c";
        if($level <= 200) return "#594c78";
        if($level <= 300) return "#3e5533";
        if($level <= 400) return "#4e3f37";
        
        return "#3b596e";
    }

    function levelIcon($level) {
        $badge = '<svg version="1.1" id="Layer_2" xmlns="https://www.w3.org/2000/svg" xmlns="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 260 260" style="enable-background: new 0 0 260 260; max-width: 150px; display: block; margin: auto;" xml:space="preserve">';
            $badge .= '<rect x="54.3" y="55" transform="matrix(0.7071 0.7071 -0.7071 0.7071 129.7883 -53.3366)" style="fill:'.colorTritary($level).';stroke:'.colorSecondary($level).';stroke-width:7;stroke-miterlimit:10;" width="150" height="150"></rect>';
            $badge .= '<polyline style="fill:'.colorPrimary($level).'; " points="233.6,125 235.8,127.2 129.8,233.3 23.7,127.2 25.9,125 129.8,205.9 "></polyline>';
            $badge .= '<path style="fill:'.colorPrimary($level).';" d="M54,96.9l13.8,4.8l37.8-37.8c-1.6-4.6-3.2-9.2-4.8-13.8C85.3,65.7,69.7,81.3,54,96.9z"></path>';
            $badge .= '<path style="fill:'.colorPrimary($level).';" d="M158.3,50.1l-4.8,13.8l37.8,37.8c4.6-1.6,9.2-3.2,13.8-4.8C189.5,81.3,173.9,65.7,158.3,50.1z"></path>';
            $badge .= '<path style="fill:'.colorPrimary($level).';" d="M113.9,36.9l-13.8-4.8L62.3,70c1.6,4.6,3.2,9.2,4.8,13.8C82.7,68.1,98.3,52.5,113.9,36.9z"></path>';
            $badge .= '<path style="fill:'.colorPrimary($level).';" d="M144.9,36.9l13.8-4.8L196.5,70c-1.6,4.6-3.2,9.2-4.8,13.8C176.1,68.1,160.5,52.5,144.9,36.9z"></path>';
            $badge .= '<polygon style="fill:'.colorPrimary($level).';" points="129.3,218.8 98.1,218.8 62.6,170.9"></polygon>';
            $badge .= '<polygon style="fill:'.colorPrimary($level).';" points="129.3,218.8 160.4,218.8 195.9,170.9"></polygon>';
            $badge .= '<path style="fill:none;stroke:'.colorSecondary($level).';stroke-width:9;stroke-miterlimit:10;" d="M129.6,193c-27.5-22.1-55.1-44.1-82.6-66.2l82.9-82.9l82.6,82.6C184.9,148.7,157.3,170.8,129.6,193z"></path>';
            $badge .= '<path style="fill:'.colorPrimary($level).';" d="M129.8,36l-3.6,10.5L155,75.3c3.5-1.2,7-2.4,10.5-3.6C153.6,59.8,141.7,47.9,129.8,36z"></path>';
            $badge .= '<path style="fill:'.colorPrimary($level).';" d="M129.8,36l3.6,10.5l-28.8,28.9c-3.5-1.2-7-2.4-10.5-3.6C106,59.8,117.9,47.9,129.8,36z"></path>';
            $badge .= '<polygon style="fill:'.colorPrimary($level).';" points="119.2,165.8 129.5,176.1 140,165.7 158.8,165.7 129.6,194.9 100.6,165.9 "></polygon>';
            $badge .= '<rect style="fill:'.colorPrimary($level).';" x="121.9" y="154.1" transform="matrix(0.7071 0.7071 -0.7071 0.7071 152.308 -44.2157)" width="15.3" height="15.3"></rect>';

            if(($level % 100) == 0) {
                $badge .= '<path style="fill:'.colorPrimary($level).';" d="M77.9,167.8c-15.2-0.3-30.5-0.6-45.7-1l-16.1-16.1c13.7,0.4,27.3,0.8,41,1.2C64,157.2,70.9,162.5,77.9,167.8z">></path>';
                $badge .= '<path style="fill:'.colorPrimary($level).';" d="M182.1,167.8c15.2-0.3,30.5-0.6,45.7-1l16.1-16.1c-13.7,0.4-27.3,0.8-41,1.2C196,157.2,189.1,162.5,182.1,167.8z"></path>';
                $badge .= '<path style="fill:'.colorPrimary($level).';" d="M102.7,186.8c-17.4-0.2-34.9-0.4-52.3-0.6l-16.1-16.1c16.3,0.5,32.6,0.9,48.9,1.4C89.7,176.6,96.2,181.7,102.7,186.8z"></path>';
                $badge .= '<path style="fill:'.colorPrimary($level).';" d="M156.4,186.8c17.6-0.1,35.3-0.2,52.9-0.3l16.1-16.1c-16.1,0-32.2,0.1-48.3,0.1C170.2,175.9,163.3,181.4,156.4,186.8z"></path>';
                $badge .= '<polygon style="fill:'.colorPrimary($level).';" points="129.8,205.9 68.4,205.9 52.3,189.8 104.4,189.8 "></polygon>';
                $badge .= '<polygon style="fill:'.colorPrimary($level).';" points="129.7,205.9 191.1,205.9 207.2,189.8 155.1,189.8 "></polygon>';
            }

            if(($level % 100) >= 50) {
                $badge .= '<path style="fill:'.colorPrimary($level).';" d="M102.7,186.8c-17.4-0.2-34.9-0.4-52.3-0.6l-16.1-16.1c16.3,0.5,32.6,0.9,48.9,1.4C89.7,176.6,96.2,181.7,102.7,186.8z"></path>';
                $badge .= '<path style="fill:'.colorPrimary($level).';" d="M156.4,186.8c17.6-0.1,35.3-0.2,52.9-0.3l16.1-16.1c-16.1,0-32.2,0.1-48.3,0.1C170.2,175.9,163.3,181.4,156.4,186.8z"></path>';
            }
            
            if(($level % 100) >= 25) {
                $badge .= '<polygon style="fill:'.colorPrimary($level).';" points="129.8,205.9 68.4,205.9 52.3,189.8 104.4,189.8 "></polygon>';
                $badge .= '<polygon style="fill:'.colorPrimary($level).';" points="129.7,205.9 191.1,205.9 207.2,189.8 155.1,189.8 "></polygon>';
            }

            $badge .= '<text x="80" y="140" textlength="100" lengthAdjust="spacingAndGlyphs" class="number">'.number_format($level).'</text>';

        $badge .= "</svg>";

        return $badge;
    }
