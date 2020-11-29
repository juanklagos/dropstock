# Display Site Title and Tagline Text in Header

The Divi Theme has a highly configurable header. One thing that is missing, however, is an easy way to display a text-based site title and tagline alongside, or in place of the logo. 

For example:

![Site title and tagline example](file://screenshot-frontend-title-and-tagline-horizontal.png)

Here's how to do it using Divi Booster or, if you prefer, manually via PHP / CSS code.

## Using Divi Booster to add Title / Tagline

Divi Booster includes an option to display the site title and tagline in the header. It'll appear next to the logo or, if you hide the logo, in place of it.

The feature is found on the Divi Booster settings page at:

"Header > Main Header > Show site title and tagline in header". 

![Divi Booster Site title and tagline feature](file://feature-site-title-and-tagline.png)

The feature is available in Divi Booster 2.3.7 onwards. 

### Layout

The "Layout" sub-setting lets you control how the site title and tagline are displayed. 

It offers four options:

* Tagline beside title
* Tagline below title
* Title only
* Tagline only

The layout option is available in Divi Booster 2.9.6 onwards. In earlier versions the tagline is displayed beside the title.

![Divi Booster Site title and tagline feature](file://layout/133-header-title-and-tagline-layout.png)

## Adding the Title / Tagline using PHP and CSS

If you don't have Divi Booster, you can manually add the site title and tagline to your site using the following PHP / CSS code: 

[PHP: Add title / tagline markup to header](file://add-site-title-and-tagline-to-header.php)

[CSS: Tagline beside title](file://layout/layout_horizontal.css)

### Layout

The CSS above implements a "horizontal" layout with the tagline shown beside the title. To achieve a different layout, *add* your choice of the following CSS snippets to your site, in addition to the CSS given above.

[CSS: Tagline below title](file://layout/layout_vertical.css)

[CSS: Title only](file://layout/layout_title_only.css)

[CSS: Tagline only](file://layout/layout_tagline_only.css)

## Additional Tips

### Hiding the logo

If you want, you can hide the logo from the Theme Customizer ("Header & Navigation > Primary Menu Bar > Hide Logo Image").

### Styling notes

The code adds the title and tagline to the left of the logo.

It does only the minimal of styling, but you can control their size, color, etc, from the "Typography" section of the Theme Customizer - it will use the "header" styles. You can override these via CSS, using the "#logo-text" and "#logo-tagline" selectors.

To avoid the header getting to overcrowded, the code hides the tagline on mobile devices.