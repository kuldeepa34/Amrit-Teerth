-- ============================================================
--  SacredPath — local dev database user
--  Creates a dedicated application user (never use root for the app).
--  Run once as admin:   sudo mariadb < database/setup.sql
--
--  NOTE: this password is for LOCAL DEVELOPMENT only. On Hostinger you
--  will use the DB user/password from hPanel instead (edit config/database.php).
-- ============================================================

CREATE USER IF NOT EXISTS 'sacredpath'@'localhost'  IDENTIFIED BY 'sacredpath';
CREATE USER IF NOT EXISTS 'sacredpath'@'127.0.0.1'  IDENTIFIED BY 'sacredpath';

GRANT ALL PRIVILEGES ON `sacredpath`.* TO 'sacredpath'@'localhost';
GRANT ALL PRIVILEGES ON `sacredpath`.* TO 'sacredpath'@'127.0.0.1';

FLUSH PRIVILEGES;
