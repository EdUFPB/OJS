<?php
// ============================================================
// ARQUIVO DE NOTÍCIAS DO PORTAL
// Para adicionar uma notícia, copie um bloco abaixo e preencha.
// A data deve estar no formato 'YYYY-MM-DD'.
// As 3 notícias mais recentes aparecem na página inicial.
// ============================================================

$noticias = [
    [
        'titulo'   => 'Portal de Periódicos da UFPB passa por atualização',
        'resumo'   => 'O Portal foi atualizado com nova seção de indexadores e funcionalidades, facilitando a navegação de autores e leitores.',
        'data'     => '2026-06-01',
        'link'     => 'sobre.php',
        'categoria'=> 'Institucional',
    ],
    [
        'titulo'   => 'Novo manual de preenchimento de metadados disponível',
        'resumo'   => 'Foi publicado o Manual de Preenchimento de Metadados no OJS, com orientações detalhadas para editores e autores conforme as normas ABNT.',
        'data'     => '2026-06-08',
        'link'     => '#',
        'categoria'=> 'Editorial',
    ],
    [
        'titulo'   => 'Chamada aberta para novos periódicos incubados',
        'resumo'   => 'O Portal recebe propostas de novos periódicos científicos para ingresso no programa de incubação. Confira os requisitos e prazos.',
        'data'     => '2026-05-20',
        'link'     => 'sobre.php',
        'categoria'=> 'Chamada',
    ],
];

// Ordena por data (mais recente primeiro)
usort($noticias, function($a, $b) {
    return strcmp($b['data'], $a['data']);
});
?>
