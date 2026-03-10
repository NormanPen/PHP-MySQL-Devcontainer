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

Die Anwendung ist dann im Browser unter `http://localhost:8080/` erreichbar.

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
