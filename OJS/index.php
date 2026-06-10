<?php
    include 'header.html';
    require_once 'dados.php';
    $revistas_json = json_encode($revistas, JSON_UNESCAPED_UNICODE);
?>

<style>
/* ===== MOBILE ===== */
@media (max-width: 768px) {
    #hero h1 { font-size: 22px !important; }
    #hero p  { font-size: 13px !important; }
    #hero .search-box { padding: 10px 16px 10px 36px !important; font-size: 13px !important; }
    #colecoes .row > div { width: 100% !important; margin-bottom: 1em; }
    #four .flex-wrap > div { min-width: 100% !important; }
    .sobre-stats { gap: 1.5rem !important; }
}

/* ===== CARDS MESMA ALTURA ===== */
#colecoes .row { display: flex !important; flex-wrap: wrap; align-items: stretch; }
#colecoes .row > div { display: flex; }
#colecoes .row > div .box { display: flex; flex-direction: column; width: 100%; }
#colecoes .row > div .box p { flex: 1; }

/* ===== HERO ===== */
#hero {
    background: linear-gradient(135deg, #E8682A 0%, #c4521e 100%);
    padding: 70px 0 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
#hero::before {
    content:''; position:absolute; top:-80px; right:-80px;
    width:340px; height:340px; border-radius:50%;
    background:rgba(255,255,255,0.07); pointer-events:none;
}
#hero::after {
    content:''; position:absolute; bottom:-100px; left:-60px;
    width:280px; height:280px; border-radius:50%;
    background:rgba(255,255,255,0.05); pointer-events:none;
}
#hero .hero-inner { position:relative; z-index:2; }

/* ===== AUTOCOMPLETE ===== */
.search-container { position: relative; max-width: 500px; margin: 0 auto; }
.autocomplete-list {
    display: none;
    position: absolute;
    top: calc(100% + 6px);
    left: 0; right: 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    z-index: 9999;
    overflow: hidden;
    text-align: left;
    max-height: 280px;
    overflow-y: auto;
}
.autocomplete-item {
    padding: 10px 16px;
    cursor: pointer;
    border-bottom: 1px solid #f5f5f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #333;
}
.autocomplete-item:last-child { border-bottom: none; }
.autocomplete-item:hover, .autocomplete-item.ativo { background: #fff5f0; }
.autocomplete-item .tag {
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 10px;
    background: #fde8d8;
    color: #993c1d;
    white-space: nowrap;
    flex-shrink: 0;
}
.autocomplete-vazia { padding: 12px 16px; font-size: 13px; color: #999; }
</style>

<!-- Hero Banner -->
<section id="hero">
    <div class="container hero-inner">
        <h1 style="color: #fff; font-size: 32px; font-weight: 800; margin: 0 0 0.4em; font-family: 'Inter', Helvetica, sans-serif; letter-spacing: -0.02em;">
            Explore os periódicos científicos da UFPB
        </h1>
        <p style="color: rgba(255,255,255,0.88); font-size: 14px; max-width: 520px; margin: 0 auto 1.5em; line-height: 1.7;">
            Pesquise por título, área ou ISSN — encontre periódicos relevantes rapidamente e acesse produções de alta qualidade técnica e científica.
        </p>

        <div class="search-container">
            <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #999; pointer-events:none;">🔍</span>
            <form id="formBusca" method="GET" action="busca.php" autocomplete="off" style="margin:0;">
                <input type="text" id="campoBusca" name="q"
                    placeholder="Buscar periódico por nome, ISSN ou palavra-chave"
                    class="search-box"
                    style="width: 100%; padding: 13px 20px 13px 40px; border-radius: 40px; border: none; font-size: 14px; box-sizing: border-box; background: #f2f4f6; outline: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);"
                    aria-label="Buscar periódico"
                    aria-autocomplete="list">
            </form>
            <div class="autocomplete-list" id="autocompleteList" role="listbox"></div>
        </div>

        <div style="margin-top: 1.2em;">
            <span style="background: rgba(255,255,255,0.18); color: white; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">✦ Open Access</span>
        </div>
    </div>
</section>

<!-- Nossas Coleções -->
<section id="colecoes" class="wrapper style2">
    <div class="container">
        <div style="text-align: left; margin-bottom: 2em;">
            <h2 style="font-size: 28px; font-family: 'Inter', Helvetica, sans-serif; margin-bottom: 0.3em;"><strong>Nossas Coleções</strong></h2>
            <p style="font-size: 14px; line-height: 1.4; color: #808080;">Navegue pelos nossos catálogos organizados por status e maturidade editorial.</p>
        </div>
        <div class="row 150%">
            <div class="3u 12u$(medium)">
                <section class="box" style="text-align: center; padding: 1.2em;">
                    <a href="periodicos.php"><i class="icon rounded fas fa-book" style="background-color: #E05A2B;"></i></a>
                    <h3 style="font-size: 16px; margin: 0.5em 0;"><strong>Correntes</strong></h3>
                    <p style="font-size: 13px; line-height: 1.4;">Periódicos em plena atividade editorial, com publicações regulares e avaliação por pares.</p>
                    <a href="periodicos.php" class="button alt small">Ver coleção →</a>
                </section>
            </div>
            <div class="3u 12u$(medium)">
                <section class="box" style="text-align: center; padding: 1.2em;">
                    <a href="incubadas.php"><i class="icon rounded fas fa-leaf" style="background-color: #1B3A6B;"></i></a>
                    <h3 style="font-size: 16px; margin: 0.5em 0;"><strong>Incubados</strong></h3>
                    <p style="font-size: 13px; line-height: 1.4;">Novos projetos editoriais em fase de estruturação dentro do portal.</p>
                    <a href="incubadas.php" class="button alt small">Ver coleção →</a>
                </section>
            </div>
            <div class="3u 12u$(medium)">
                <section class="box" style="text-align: center; padding: 1.2em;">
                    <a href="nao-correntes.php"><i class="icon rounded fas fa-archive" style="background-color: #808080;"></i></a>
                    <h3 style="font-size: 16px; margin: 0.5em 0;"><strong>Não Correntes</strong></h3>
                    <p style="font-size: 13px; line-height: 1.4;">Periódicos que encerraram atividades, mas permanecem como fonte essencial de consulta.</p>
                    <a href="nao-correntes.php" class="button alt small">Ver coleção →</a>
                </section>
            </div>
            <div class="3u$ 12u$(medium)">
                <section class="box" style="text-align: center; padding: 1.2em;">
                    <a href="anais-eventos.php"><i class="icon rounded fa fa-calendar" style="background-color: #2e8a6a;"></i></a>
                    <h3 style="font-size: 16px; margin: 0.5em 0;"><strong>Publicações de Eventos</strong></h3>
                    <p style="font-size: 13px; line-height: 1.4;">Anais e revistas vinculados a congressos, colóquios e encontros científicos da UFPB.</p>
                    <a href="anais-eventos.php" class="button alt small">Ver coleção →</a>
                </section>
            </div>
        </div>
    </div>
</section>

<!-- Sobre -->
<section id="three" style="background: #f2f4f6; border-top: 1px solid #dde1e7; border-bottom: 1px solid #dde1e7; padding: 4em 2em; text-align: center;">
    <div class="container" style="max-width: 720px; margin: 0 auto;">

        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.12em; color: #E8682A; font-weight: 600; margin-bottom: 0.4rem;">Sobre o portal</p>
        <h2 style="font-size: 22px; color: #1B3A6B; font-weight: 700; margin-bottom: 1.25rem;">Ciência aberta da Paraíba para o mundo</h2>

        <p style="font-size: 14px; line-height: 1.85; color: #3d5070; margin-bottom: 1.75em; text-align: justify;">
            O Portal de Periódicos da UFPB constitui um espaço estratégico para a comunicação científica da Universidade Federal da Paraíba, promovendo a preservação da memória científica institucional, a visibilidade da produção acadêmica, a ciência aberta e a democratização do acesso ao conhecimento. Por meio dos periódicos editados e gerenciados por pesquisadores vinculados à UFPB, contribui para a disseminação da produção científica nacional e internacional, fortalecendo o impacto da ciência, da inovação e da pesquisa na sociedade.
        </p>

        <div style="margin-bottom: 2em;">
            <span style="background: #e0e6ef; color: #1B3A6B; padding: 5px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">✦ Open Access</span>
        </div>

        <div style="display: flex; justify-content: center; gap: 3.5em; flex-wrap: wrap; margin-bottom: 2em;">
            <div>
                <p style="font-size: 38px; font-weight: 800; color: #1B3A6B; margin: 0; line-height: 1;">+70</p>
                <p style="font-size: 11px; color: #6b7a99; margin: 6px 0 0; text-transform: uppercase; letter-spacing: 1.5px;">Periódicos</p>
            </div>
            <div>
                <p style="font-size: 38px; font-weight: 800; color: #1B3A6B; margin: 0; line-height: 1;">+27.000</p>
                <p style="font-size: 11px; color: #6b7a99; margin: 6px 0 0; text-transform: uppercase; letter-spacing: 1.5px;">Artigos Publicados</p>
            </div>
        </div>

        <a href="sobre.php" style="background: #E8682A; color: white; padding: 11px 30px; font-size: 14px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;">Saiba Mais</a>

    </div>
</section>

<!-- Equipe -->
<div style="padding: 2.5rem 2rem; text-align: center; background: #ffffff; border-top: 1px solid #e0e0e0;">
    <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #E8682A; font-weight: 500; margin-bottom: 0.5rem;">Equipe</p>
    <h3 style="font-size: 18px; font-weight: 500; color: #444; margin-bottom: 2rem;">Conheça as profissionais que garantem o funcionamento e a qualidade científica do nosso portal.</h3>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; max-width: 600px; margin: 0 auto;">
        <div style="display: flex; flex-direction: column; align-items: center; gap: 6px;">
            <img src="images/ana.png" alt="Ana Roberta Mota" width="60" height="60" style="border-radius: 50%; object-fit: cover; object-position: center; filter: grayscale(100%); border: 3px solid #E8682A; margin-bottom: 4px;" />
            <span style="font-size: 14px; font-weight: 500; color: #444;">Ana Roberta Mota</span>
            <span style="font-size: 12px; color: #E8682A;">Bibliotecária</span>
            <a href="http://lattes.cnpq.br/6636072425703164" target="_blank" style="font-size: 12px; color: #888; text-decoration: none; border-bottom: 0.5px solid #ccc;">Currículo Lattes</a>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center; gap: 6px;">
            <img src="images/cassandra.jpg" alt="Cassandra Campos" width="60" height="60" style="border-radius: 50%; object-fit: cover; filter: grayscale(100%); border: 3px solid #E8682A; margin-bottom: 4px;" />
            <span style="font-size: 14px; font-weight: 500; color: #444;">Cassandra Campos</span>
            <span style="font-size: 12px; color: #E8682A;">Editora de Publicações</span>
            <a href="http://lattes.cnpq.br/8767155212928230" target="_blank" style="font-size: 12px; color: #888; text-decoration: none; border-bottom: 0.5px solid #ccc;">Currículo Lattes</a>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center; gap: 6px;">
            <img src="images/fabi.png" alt="Fabiana França" width="60" height="60" style="border-radius: 50%; object-fit: cover; filter: grayscale(100%); border: 3px solid #E8682A; margin-bottom: 4px;" />
            <span style="font-size: 14px; font-weight: 500; color: #444;">Fabiana França</span>
            <span style="font-size: 12px; color: #E8682A;">Bibliotecária</span>
            <a href="http://lattes.cnpq.br/0843349256910839" target="_blank" style="font-size: 12px; color: #888; text-decoration: none; border-bottom: 0.5px solid #ccc;">Currículo Lattes</a>
        </div>
    </div>
</div>

<!-- OJS -->
<section id="four" style="background-color: #f2f4f6; border-top: 1px solid #dde1e7; padding: 4em 2em;">
    <div class="container">
        <div style="display: flex; align-items: center; gap: 3em; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 280px;">
                <span style="background: #e0e6ef; color: #1B3A6B; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase;">🖥 Infraestrutura de Ponta</span>
                <h2 style="color: #1B3A6B; font-size: 26px; margin-top: 0.8em; line-height: 1.3;"><strong>Baseado no ecossistema Open Journal Systems (OJS)</strong></h2>
                <p style="color: #3d5070; font-size: 14px; line-height: 1.8; max-width: 450px;">Utilizamos o padrão ouro global para publicação científica de código aberto. Uma interface intuitiva para submissões, avaliação por pares e publicação rápida.</p>
                <div style="display: flex; gap: 1em; margin-top: 1.5em; flex-wrap: wrap;">
                    <a href="acesso.php" style="background: #E8682A; color: white; padding: 12px 24px; border-radius: 8px; font-size: 14px; text-decoration: none; font-weight: bold;">Acesse a plataforma</a>
                </div>
            </div>
            <div style="flex: 1; min-width: 280px;">
                <div style="background: white; border-radius: 12px; padding: 1.5em; box-shadow: 0 8px 24px rgba(0,0,0,0.1);">
                    <img src="images/ojs.png" alt="OJS" style="width: 100%; border-radius: 8px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script de Autocomplete -->
<script>
var revistas = <?php echo $revistas_json; ?>;
var labels = { correntes: 'Corrente', incubados: 'Incubado', 'nao-correntes': 'Não Corrente', 'anais-eventos': 'Pub. Eventos' };

function removerAcentos(str) {
    return str.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();
}

var campo = document.getElementById('campoBusca');
var lista  = document.getElementById('autocompleteList');
var ativo  = -1;

campo.addEventListener('input', function() {
    var termo = removerAcentos(this.value.trim());
    lista.innerHTML = '';
    ativo = -1;
    if (termo.length < 2) { lista.style.display = 'none'; return; }

    var encontrados = revistas.filter(function(r) {
        return removerAcentos(r.nome).indexOf(termo) !== -1;
    }).slice(0, 8);

    if (encontrados.length === 0) {
        lista.innerHTML = '<div class="autocomplete-vazia">Nenhum periódico encontrado.</div>';
    } else {
        encontrados.forEach(function(r) {
            var item = document.createElement('div');
            item.className = 'autocomplete-item';
            item.setAttribute('role', 'option');
            item.innerHTML = '<span>' + r.nome + '</span><span class="tag">' + (labels[r.colecao] || r.colecao) + '</span>';
            item.addEventListener('mousedown', function(e) {
                e.preventDefault();
                if (r.link) { window.open(r.link, '_blank'); }
                else { campo.value = r.nome; document.getElementById('formBusca').submit(); }
                lista.style.display = 'none';
            });
            lista.appendChild(item);
        });
    }
    lista.style.display = 'block';
});

campo.addEventListener('keydown', function(e) {
    var itens = lista.querySelectorAll('.autocomplete-item');
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        ativo = Math.min(ativo + 1, itens.length - 1);
        itens.forEach(function(el, i) { el.classList.toggle('ativo', i === ativo); });
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        ativo = Math.max(ativo - 1, -1);
        itens.forEach(function(el, i) { el.classList.toggle('ativo', i === ativo); });
    } else if (e.key === 'Escape') {
        lista.style.display = 'none';
    }
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('.search-container')) lista.style.display = 'none';
});
</script>

<?php include 'footer.html'; ?>
