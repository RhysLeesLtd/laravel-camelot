# rhysleesltd/laravel-camelot

A **Laravel wrapper** for [Camelot](https://github.com/camelot-dev/camelot)—the Python PDF table extraction library. Extract tabular data from PDFs in your Laravel app using the same API as the Camelot CLI, with Laravel helpers (e.g. `Arr::`, `Collection::`) and auto-discovered service provider.

## Installation

You need both the PHP package and the Python Camelot library (this package calls the Camelot CLI under the hood).

### 1. PHP package (Laravel)

```bash
composer require rhysleesltd/laravel-camelot
```

The `CamelotServiceProvider` is auto-discovered; no manual registration is required.

### 2. Python Camelot

Install Camelot so the `camelot` command is available on your system path. Full details: [Camelot installation docs](https://camelot-py.readthedocs.io/en/master/user/install.html).

#### Linux (Ubuntu / Debian)

```bash
# Optional: Ghostscript (only if you need a backend other than pdfium)
sudo apt install ghostscript

# Install Camelot (pdfium is the default backend as of v1.0.0)
pip install "camelot-py[base]"
```

Or with conda: `conda install -c conda-forge camelot-py`.

#### macOS

```bash
# Optional: Ghostscript (only if you need a backend other than pdfium)
brew install ghostscript

# Install Camelot
pip install "camelot-py[base]"
```

If the Ghostscript library is not found, you may need to symlink it (see the [Camelot dependency docs](https://camelot-py.readthedocs.io/en/master/user/install-deps.html)).

#### Windows

```bash
pip install "camelot-py[base]"
```

For optional Ghostscript, use the [Ghostscript Windows installer](https://www.ghostscript.com/download/gsdnld.html). For Tkinter (e.g. for plot), you may need [ActiveTcl](https://www.activestate.com/activetcl/downloads). See [Camelot dependencies](https://camelot-py.readthedocs.io/en/master/user/install-deps.html) for details.

---

Verify the CLI works: `camelot --help`

## Usage

The package adheres closely with the camelot CLI API Usage.
Default output is in CSV format as a simple string. If you need to parse CSV strings we recommend the `league/csv` package (https://csv.thephpleague.com/)

```php
<?php

use RhysLeesLtd\Camelot\Camelot;
use League\Csv\Reader;

$tables = Camelot::lattice('/path/to/my/file.pdf')
       ->extract();

$csv = Reader::createFromString($tables[0]);
$allRecords = $csv->getRecords();
```

### Advanced Processing

##### Saving / Extracting
**Note: No Camelot operations are run until one of these methods is run**
```php
$camelot->extract(); // uses temporary files and automatically grabs the table contents for you from each
$camelot->save('/path/to/my-file.csv'); // mirrors the behaviour of Camelot and saves files in the format /path/to/my-file-page-*-table-*.csv
$camelot->plot(); // useful for debugging, it will plot it in a separate window (see Visual Debugging below)   
```

##### [Set Format](https://camelot-py.readthedocs.io/en/master/user/quickstart.html#read-the-pdf)
```
$camelot->json();
$camelot->csv();
$camelot->html();
$camelot->excel();
$camelot->sqlite();
```
##### [Specify Page Numbers](https://camelot-py.readthedocs.io/en/master/user/quickstart.html#specify-page-numbers)

`$camelot->pages('1,2,3-4,8-end')`

##### [Reading encrypted PDFs](https://camelot-py.readthedocs.io/en/master/user/quickstart.html#reading-encrypted-pdfs)

`$camelot->password('my-pass')`

##### [Processing background lines](https://camelot-py.readthedocs.io/en/master/user/advanced.html#process-background-lines)
`$camelot->stream()->processBackgroundLines()`

##### [Visual debugging](https://camelot-py.readthedocs.io/en/master/user/advanced.html#visual-debugging)

`$camelot->plot()`

##### [Specify table areas](https://camelot-py.readthedocs.io/en/master/user/advanced.html#specify-table-areas)

```php
<?php

use RhysLeesLtd\Camelot\Camelot;
use RhysLeesLtd\Camelot\Areas;

Camelot::stream('my-file.pdf')
    ->inAreas(
        Areas::from($xTopLeft, $yTopLeft, $xBottomRight, $yBottomRight)
            // ->add($xTopLeft2, $yTopLeft2, $xBottomRight2, $yBottomRight2)
            // ->add($xTopLeft3, $yTopLeft3, $xBottomRight3, $yBottomRight3)
    );
```

##### [Specify table regions](https://camelot-py.readthedocs.io/en/master/user/advanced.html#specify-table-regions)

```php
<?php

use RhysLeesLtd\Camelot\Camelot;
use RhysLeesLtd\Camelot\Areas;

Camelot::stream('my-file.pdf')
    ->inRegions(
        Areas::from($xTopLeft, $yTopLeft, $xBottomRight, $yBottomRight)
            // ->add($xTopLeft2, $yTopLeft2, $xBottomRight2, $yBottomRight2)
            // ->add($xTopLeft3, $yTopLeft3, $xBottomRight3, $yBottomRight3)
    );
```
 
##### [Specify column separators](https://camelot-py.readthedocs.io/en/master/user/advanced.html#specify-column-separators)

`$camelot->stream()->setColumnSeparators($x1,$x2...)`

##### [Split text along separators](https://camelot-py.readthedocs.io/en/master/user/advanced.html#split-text-along-separators)

`$camelot->split()`

##### [Flag superscripts and subscripts](https://camelot-py.readthedocs.io/en/master/user/advanced.html#flag-superscripts-and-subscripts)

`$camelot->flagSize()`

##### [Strip characters from text](https://camelot-py.readthedocs.io/en/master/user/advanced.html#strip-characters-from-text)

`$camelot->strip("\n")`

##### [Improve guessed table areas](https://camelot-py.readthedocs.io/en/master/user/advanced.html#improve-guessed-table-areas)

`$camelot->setEdgeTolerance(500)`

##### [Improve guessed table rows](https://camelot-py.readthedocs.io/en/master/user/advanced.html#improve-guessed-table-rows)

`$camelot->setRowTolerance(15)`

##### [Detect short lines](https://camelot-py.readthedocs.io/en/master/user/advanced.html#detect-short-lines)

`$camelot->lineScale(20)`


##### [Shift text in spanning cells](https://camelot-py.readthedocs.io/en/master/user/advanced.html#shift-text-in-spanning-cells)

`$camelot->shiftText('r', 'b')`

##### [Copy text in spanning cells](https://camelot-py.readthedocs.io/en/master/user/advanced.html#copy-text-in-spanning-cells)

`$camelot->copyTextSpanningCells('r', 'b')`

## Credits

This package is a Laravel-oriented fork of the original PHP wrappers for Camelot. Thanks to:

- **[randomstate/camelot-php](https://github.com/randomstate/camelot-php)** — original PHP wrapper for Camelot (by [Random State](https://randomstate.co.uk)).
- **[kayukoff/camelot-php](https://github.com/kayukoff/camelot-php)** — fork updated for Symfony 6+ and PHP 8+.

The underlying table extraction is done by **[Camelot](https://github.com/camelot-dev/camelot)** (Python). You need [Camelot installed](https://camelot-py.readthedocs.io/en/master/user/install.html) and available on your system path.

## License

MIT. Use at your own risk, we accept no liability for how this code is used.