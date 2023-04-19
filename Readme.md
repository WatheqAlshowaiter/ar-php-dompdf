# Ar-PHP with Dompdf

## Run this php project

1. install packages `composer install`.
2. serve the project. If you are on Mac you can use `php -S localhost:8080`;

### My previous Laravel code with the indentation problem

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