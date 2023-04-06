# Ar-PHP with Dompdf

## Run this project

1. install packages `composer install`.
2. serve the project. If you are on Mac you can use `php -S localhost:8080`;

## What this project solve?

Now, you can use Arabic language without unneeded indentation. see [this issue for more info](https://github.com/khaled-alshamaa/ar-php/issues/59#issue-1561170023).

## What I want from this project to solve?

Yes indentation was solved, but I have 2 problems now:

1. No background image was loaded.
2. Can not load My Custom font.

These problems above was not a problem in the previous Laravel code. I want to solve all three problems.

### My previous Laravel Code with only the first problem (indentation)

1. download `barryvdh/laravel-dompdf` which is a wrapper around dompdf/dompdf" and download `khaled.alshamaa/ar-php`.

2. inside [this line](https://github.com/dompdf/dompdf/blob/master/src/Renderer/Text.php#L74) in the dompdf package we have added.

```php
if ( ! class_exists( 'I18N_Arabic' ) ){
    $Arabic = new Arabic();
    $text = $Arabic->utf8Glyphs($text);
}
```

3. use the package
```php
Route::get('create-pdf', function () {
    $pdf = PDF::loadView('sample'); //sample.blade.php = sample.html in this project
    return $pdf->stream();
});
```
