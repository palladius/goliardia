
-- SQL da iniettare in staging per far capire al povero sviluppatore che siamo chiaramente NON in prod.
-- Qualche idea:
-- 1. Cambiare i XXX_MEMOZ cambiando prod con staging
-- 2. Aggiungere un messaggio con data di now() che dice "siamo in staging!" - di solito lo fo a mmano.
--
-- Sarebbe bello da auomatizzare :) Tipo:




-- NOta che alcune NON sono idempotenti - se lanci lo script 2 volte SPORCHI :)
UPDATE xxx_memoz SET valore = "staging" WHERE chiave = "db_type";
UPDATE xxx_memoz SET valore = concat("[HEADER] ",valore ) WHERE chiave = "fotoprimapagina";
UPDATE xxx_memoz SET valore = concat(valore, "_staging") WHERE chiave = "DB_VER";
UPDATE xxx_memoz SET valore = concat(valore, " (staging)") WHERE chiave = "qgfdp";


INSERT INTO `messaggi` (`id_msg`, `titolo`, `id_login`, `messaggio`, `data_creazione`, `pubblico`, `id_figliodi_msg`, `id_tipo`)
    VALUES (NULL, '[STAGING][NOW] Siamo in staging (rake db:seed)', '3', 'Siamo in staging - sbrozzo di eNV vars utili\r\ne current timestamp\nda rake db:migrate :)',
        NOW(), '1', 0, 0);