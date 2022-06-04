# SS Theme Tweaks

Just another WordPress plugin. More specifically this is a WordPress functionality plugin in the sense that it adds
custom functionality to your site/theme.

## Requirements

* [PHP](https://secure.php.net/manual/en/install.php) >= 7.4.0.

## Plugin installation

* Install it like you'd do with any other WordPress plugin.

## Features

1. Remove the following image sizes created by WordPress:
    * `1536x1536`.
    * `2048x2048`.
    * `medium_large`.
2. Automagically update an image alt text with its parent title (during upload):
    * For instance, if you upload an image through a page called Contact that image will have its alternative text
      updated to Contact.
3. Improves the way WordPress sanitizes a file name:
    * WordPress already does a good work sanitizing a file name. Additionally, this plugin converts all characters to
      lowercase and adds a suffix based on the date to the filename to prevent image caching. E.g. "Image.png" turns
      into "image6382612.png".
4. Makes WordPress library (when opened inside a post) display only the images attached to the current post being edited.

## License

This project is licensed under the GPL-3.0 license.