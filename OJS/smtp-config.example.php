<?php
/**
 * ============================================================
 *  MODELO — Credenciais SMTP (Central de Ajuda)
 * ============================================================
 *  Este arquivo É seguro para o Git (não tem segredo nenhum).
 *
 *  Para configurar um servidor novo:
 *   1) Copie este arquivo para "smtp-config.php" (mesma pasta)
 *   2) Preencha SMTP_PASS com a senha de app real, gerada em
 *      https://myaccount.google.com/apppasswords
 *   3) Confirme que "smtp-config.php" está no .gitignore do
 *      projeto, para nunca ser commitado por engano.
 * ============================================================
 */

define('SMTP_USER', 'periodicos.ufpb@gmail.com');
define('SMTP_PASS', 'COLE_AQUI_A_SENHA_DE_APP_DE_16_LETRAS');
