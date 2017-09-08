# Super Thumbs

Give superpowers to your thumbnails!

**The first feature:** You can add a format to automatically convert `png` to `jpg` files.

**[Installation instructions](docs/install.md)**

## Format

Add a format to automatically convert `png` to `jpg` files.

- `quality` is supported by this feature (set to 90 by default).
- `format` as param will override the config `thumbs.format`
- The `png` thumbnail file is not deleted by the conversion process. If you are deleting this plugin, the cached `png` thumbnail file will be used instead.

### As param

```php
echo thumb($page->image(), array('width' => 300, 'quality' => 80, 'format' => 'jpg'));
```

If the file is in `png` format, it will be converted to `jpg`. It will take `quality` into account.

### As config

To format all files as `jpg` you can set this in your `config.php` file.

```php
c::set('thumbs.format', 'jpg');
```

## Changelog

**0.1**

- Initial release

## Requirements

- PHP 7
- GD Lib
- [**Kirby**](https://getkirby.com/) 2.5.5+
- You can not use this plugin if you already use the `thumbs` class, for example [Imagekit](https://github.com/fabianmichael/kirby-imagekit).

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/username/plugin-name/issues/new).

## License

[MIT](https://opensource.org/licenses/MIT)

It is discouraged to use this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.

## Credits

- [Jens Törnell](https://github.com/jenstornell)