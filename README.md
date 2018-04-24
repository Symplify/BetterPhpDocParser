# Better Reflection DocBlock

[![Build Status](https://img.shields.io/travis/Symplify/BetterPhpDocParser/master.svg?style=flat-square)](https://travis-ci.org/Symplify/BetterPhpDocParser)
[![Subscribe](https://img.shields.io/badge/subscribe-to--releases-green.svg?style=flat-square)](https://libraries.io/packagist/symplify%2Fbetter-phpdoc-parser)

Wrapper around [phpstan/phpdoc-parser](https://github.com/phpstan/phpdoc-parser) that adds **format preserving printer**.

## Install

```bash
composer require symplify/better-phpdoc-parser
```

## Usage

Register services in your Symfony config:

```yaml
# services.yml
imports:
    - { resource: 'vendor/symplify/better-phpdoc-parser/src/config/services.yml' }
```

or register the needed services from `services.yml` in config of your other framework.
And require services in the constructor.

### Why do we need Format Preserving Printer?

[Symplify\CodingStandard](https://github.com/symplify/codingstandard) and [Rector](github.com/rectorphp/rector) need to modify docblock and put it back in correct format. Packages on open-source market often put own spacing, or formats of specific tags. **Goal of this package is preserve origin docblock format**.

Thanks for [inspiration in *Format Preserving Printer* feature in `nikic/php-parser`](https://github.com/nikic/PHP-Parser/issues/487).

```php
use Symplify\BetterPhpDocParser\PhpDocParser\PhpDocInfoFactory;
use Symplify\BetterPhpDocParser\PhpDocParser\PhpDocInfoPrinter;

class SomeClass
{
    public function __construct(PhpDocInfoFactory $phpDocInfoFactory, PhpDocInfoPrinter $phpDocInfoPrinter)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->phpDocInfoPrinter = $phpDocInfoPrinter;
    }

    public function changeDocBlockAndPrintItBack(): string
    {
        $docComment = '/**    @var Type $variable    */

        $phpDocInfo = $this->phpDocInfoFactory->createFrom($docComment);

        // modify `$phpDocInfo` using its methods

        return $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo));
    }
}
```
