# pasek-informacyjny

Wtyczka WordPress wyświetlająca **pasek informacyjny** na stronie (nagłówek + treść). Administrator włącza komunikat, ustawia datę wygaśnięcia, kolory tekstu i tła oraz pozycję paska (góra / środek / dół). Po kliknięciu pasek chowa się na 24 godziny (cookie).

## Wymagania

- WordPress z obsługą hooka `wp_body_open` (motywy blokowe / nowsze motywy)

## Instalacja

1. Skopiuj folder wtyczki do `wp-content/plugins/` (lub wgraj spakowany katalog).
2. Aktywuj **pasek-informacyjny** w panelu WordPress.
3. W menu **Pasek info** ustaw treść, kolory, pozycję i datę zakończenia wyświetlania.

## Funkcje

| Obszar | Opis |
|--------|------|
| Front | Pasek `position: fixed`, z-index 9999, styl z opcji w bazie |
| Panel | Checkbox aktywności, `datetime-local` na koniec kampanii, color pickery |
| Wygaśnięcie | Po dacie z opcji wtyczka dezaktywuje pasek automatycznie |
| Cookie | `info_bar_show` — ukrycie po kliknięciu na 24 h |

## Pliki

- `pasek-informacyjny.php` — logika wtyczki, panel ustawień, style inline
- `img/` — grafiki (logo w panelu admina)

## Autor

**Wojciech Sowiński** — [owliedev.pl](https://owliedev.pl/)

Wersja wtyczki: **1.1** | Licencja: GPL-2.0+
