<?php include 'header.html'; ?>

<section id="main" class="wrapper" style="padding-top: 0px;">
    <div class="container">
        <header class="major mt-5">
            <h2><strong>Busca</strong></h2>
            <?php $q = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>
            <div style="position: relative; max-width: 500px; margin: 0 auto;">
                <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #999;">🔍</span>
                <input type="text" id="searchInput" value="<?php echo $q; ?>"
                    placeholder="Buscar periódico por nome, ISSN ou palavra-chave"
                    style="width: 100%; padding: 12px 20px 12px 40px; border-radius: 8px; border: 1px solid #ddd; font-size: 13px; box-sizing: border-box;"
                    onkeydown="if(event.key==='Enter'){window.location.href='busca.php?q='+this.value}">
            </div>
        </header>
        <hr/>

        <?php if($q): ?>
            <h4 style="margin-bottom: 1.5em;">Resultados para: <strong style="color: #E05A2B;"><?php echo $q; ?></strong></h4>

            <?php
            $colecoes = [
                'Periódicos Correntes'      => 'periodicos.php',
                'Periódicos Não Correntes'  => 'nao-correntes.php',
                'Periódicos Incubados'      => 'incubadas.php',
                'Parcerias'                 => 'parcerias.php',
                'Anais de Eventos'          => 'anais-eventos.php'
            ];

            $totalResults = 0;

            foreach($colecoes as $nome => $arquivo) {
                if(!file_exists($arquivo)) continue;
                $conteudo = file_get_contents($arquivo);
                preg_match_all('/<li>(.*?)<\/li>/si', $conteudo, $matches);

                $resultados = [];
                foreach($matches[1] as $item) {
                    if(stripos($item, $q) !== false) {
                        $resultados[] = $item;
                    }
                }

                if(!empty($resultados)) {
                    $totalResults += count($resultados);
                    echo "<h3 style='color: #E05A2B; margin-top: 2em; font-size: 18px;'>$nome <span style='color: #808080; font-size: 14px; font-weight: normal;'>(" . count($resultados) . " resultado(s))</span></h3>";
                    echo "<ul id='myUL'>";
                    foreach($resultados as $r) {
                        echo "<li>$r</li>";
                    }
                    echo "</ul><hr>";
                }
            }

            if($totalResults == 0) {
                echo "<div style='text-align: center; padding: 3em; color: #808080;'>";
                echo "<p style='font-size: 18px;'>Nenhum resultado encontrado para <strong style='color: #444;'>\"$q\"</strong>.</p>";
                echo "<p>Tente buscar por outro termo ou <a href='periodicos.php' style='color: #E05A2B;'>veja todos os periódicos</a>.</p>";
                echo "</div>";
            } else {
                echo "<p style='color: #808080; font-size: 13px; margin-top: 1em;'>Total: $totalResults resultado(s) encontrado(s).</p>";
            }
            ?>

        <?php else: ?>
            <p style="text-align: center; color: #808080; padding: 3em;">Digite um termo na busca acima para encontrar periódicos.</p>
        <?php endif; ?>

    </div>
</section>

<?php include 'footer.html'; ?>
