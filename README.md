# PHP + MySQL Devcontainer Template

Dieses Repository dient als Template f\u00fcr kleine PHP-Projekte mit MySQL in einem Devcontainer.

## Was ist das?

- PHP 8.2 + Apache im Devcontainer
- MySQL-Datenbank via Docker Compose
- Composer eingerichtet (inkl. PHPUnit)
- Einfache Ordnerstruktur:
  - `src/` f\u00fcr PHP-Code
  - `tests/` f\u00fcr PHPUnit-Tests
- Makefile-Kommandos f\u00fcr typische Aufgaben

## Datenbank-Migrationen

- SQL-Migrationen liegen im Ordner `migrations/` (z.B. `001_create_users.sql`).
- Der `MigrationRunner` in `src/Database/Migrations/MigrationRunner.php` f\u00fchrt neue Migrationen aus und tr\u00e4gt sie in der Tabelle `migrations` ein.
- Nach dem Start der Container kannst du das Schema so anlegen/aktualisieren:

   ```bash
   make migrate
   ```

- Aktuelle Tabellen anzeigen:

   ```bash
   make db-tables
   ```

## Wie starten?

Aus dem Projektverzeichnis auf dem Host:

1. Container bauen und starten:
   ```bash
   make up
   ```

2. Shell im PHP-Container \u00f6ffnen:
   ```bash
   make shell
   ```

3. Composer-Abh\u00e4ngigkeiten installieren (im Container ausgef\u00fchrt):
   ```bash
   make composer-install
   ```

4. Tests ausf\u00fchren (im Container ausgef\u00fchrt):
   ```bash
   make test
   ```

   Lesbare Testausgabe (Testdox-Format):
   ```bash
   make testdox
   ```

Die Anwendung ist dann im Browser unter `http://localhost:8080/` erreichbar.

## Makefile-Kommandos

Alle wichtigen Befehle auf einen Blick (immer aus dem Projektverzeichnis auf dem Host aufrufen):

- Dev-Umgebung starten und bauen:
   ```bash
   make up
   ```

- Dev-Umgebung stoppen und Container entfernen:
   ```bash
   make down
   ```

- Shell im PHP-Container:
   ```bash
   make shell
   ```

- Composer-Abhängigkeiten installieren/aktualisieren:
   ```bash
   make composer-install
   make composer-update
   ```

- PHPUnit-Tests ausführen (normal/Testdox):
   ```bash
   make test
   make testdox
   ```

- Datenbank-Migrationen ausführen:
   ```bash
   make migrate
   ```

- Tabellenübersicht der Datenbank anzeigen:
   ```bash
   make db-tables
   ```

- Testbenutzer per Script hinzufügen bzw. alle Benutzer listen:
   ```bash
   make db-add-user
   make db-list-users
   ```

- MySQL-Shell im DB-Container öffnen (DB „app“, User/Pass „app“):
   ```bash
   make mysql-shell
   ```

- Live-Reload für Views und Styles (z. B. bei CSS- oder PHP-Änderungen):
   ```bash
   make watch
   ```
  Dadurch wird ein Live-Server gestartet, der die Seite im Browser automatisch neu lädt, sobald du Änderungen an den Dateien vornimmst.

## Hinweis zu Beispielcode

- In `src/` und `tests/` befindet sich nur einfacher Beispielcode (`Example` und `ExampleTest`).
- F\u00fcr echte Projekte solltest du diese Klassen/Tests anpassen oder entfernen und deine eigene Struktur aufbauen.

## Verwendung als Template-Repository

1. Stelle sicher, dass `composer.lock` versioniert ist (im Repo liegt bereits eine Datei `composer.lock`).
2. Commits lokal erstellen, z. B.:
   ```bash
   git add .
   git commit -m "Initial PHP + MySQL devcontainer template"
   ```
3. Repository zu GitHub pushen, z. B.:
   ```bash
   git remote add origin <URL-zu-deinem-GitHub-Repo>
   git push -u origin main
   ```
4. Auf GitHub im Repo unter **Settings \u2192 Template repository** den Haken setzen.
5. F\u00fcr neue Projekte auf GitHub im Template-Repo auf **Use this template** klicken und einen neuen Projektnamen vergeben.

## E-Mails lokal testen mit Mailhog

- Im lokalen Setup werden alle E-Mails von PHP an Mailhog umgeleitet und NICHT an echte Adressen verschickt.
- Das Mailhog-Webinterface erreichst du unter: http://localhost:8025
- Dort kannst du alle Testmails (z.B. für Passwort-Reset) einsehen und die enthaltenen Links nutzen.
- E-Mails werden niemals an das echte Internet weitergeleitet oder zugestellt.
- Zum Testen des Mailversands kannst du ausführen:
  ```bash
  make test-mail
  ```
- Für produktive Umgebungen muss Mailhog durch einen echten SMTP-Server ersetzt werden.
