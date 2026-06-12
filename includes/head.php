<?php
/**
 * Shared document <head>.
 * Set $pageTitle before including this file to customise the title.
 */
$pageTitle = $pageTitle ?? SITE_NAME . ' - ' . SITE_TAGLINE;
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?= htmlspecialchars($pageTitle) ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&amp;family=Manrope:wght@400;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "inverse-surface": "#392e27",
                    "inverse-primary": "#ffb786",
                    "on-tertiary-fixed": "#0b1b36",
                    "surface-container": "#feeae0",
                    "outline": "#897365",
                    "surface-bright": "#fff8f5",
                    "secondary": "#735c00",
                    "on-surface": "#231a13",
                    "on-primary": "#ffffff",
                    "on-secondary-fixed-variant": "#574500",
                    "error-container": "#ffdad6",
                    "tertiary-fixed-dim": "#b7c7ea",
                    "on-primary-fixed": "#311400",
                    "surface-container-high": "#f8e4da",
                    "surface-dim": "#e9d6cc",
                    "surface-tint": "#954a00",
                    "surface-container-highest": "#f2dfd4",
                    "tertiary-fixed": "#d7e2ff",
                    "on-surface-variant": "#564337",
                    "on-background": "#231a13",
                    "secondary-fixed-dim": "#e9c349",
                    "on-tertiary-container": "#1e2d49",
                    "on-tertiary": "#ffffff",
                    "outline-variant": "#dcc1b2",
                    "error": "#ba1a1a",
                    "secondary-container": "#fed65b",
                    "on-secondary-container": "#745c00",
                    "on-tertiary-fixed-variant": "#384764",
                    "background": "#fff8f5",
                    "primary-fixed": "#ffdcc6",
                    "tertiary-container": "#8695b6",
                    "on-secondary-fixed": "#241a00",
                    "secondary-fixed": "#ffe088",
                    "on-error-container": "#93000a",
                    "primary-fixed-dim": "#ffb786",
                    "surface-container-lowest": "#ffffff",
                    "on-primary-fixed-variant": "#723600",
                    "surface": "#fff8f5",
                    "on-error": "#ffffff",
                    "primary-container": "#e17a24",
                    "surface-container-low": "#fff1ea",
                    "inverse-on-surface": "#ffede4",
                    "primary": "#954a00",
                    "on-secondary": "#ffffff",
                    "on-primary-container": "#4c2200",
                    "surface-variant": "#f2dfd4",
                    "tertiary": "#505e7d"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "2xl": "1rem",
                    "3xl": "1.5rem",
                    "full": "9999px"
            },
            "spacing": {
                    "margin-mobile": "20px",
                    "container-max": "1200px",
                    "margin-desktop": "64px",
                    "unit": "8px",
                    "gutter": "24px",
                    "stack-sm": "24px",
                    "stack-md": "48px",
                    "stack-lg": "80px",
                    "section": "120px"
            },
            "fontFamily": {
                    "headline-sm": ["Libre Caslon Text"],
                    "display-lg": ["Libre Caslon Text"],
                    "body-md": ["Manrope"],
                    "headline-md": ["Libre Caslon Text"],
                    "body-lg": ["Manrope"],
                    "label-caps": ["Manrope"],
                    "display-lg-mobile": ["Libre Caslon Text"]
            },
            "fontSize": {
                    "headline-sm": ["24px", { "lineHeight": "1.4", "fontWeight": "400" }],
                    "display-lg": ["48px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "400" }],
                    "body-md": ["16px", { "lineHeight": "1.6", "fontWeight": "400" }],
                    "headline-md": ["32px", { "lineHeight": "1.3", "fontWeight": "400" }],
                    "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                    "label-caps": ["12px", { "lineHeight": "1.0", "letterSpacing": "0.1em", "fontWeight": "600" }],
                    "display-lg-mobile": ["36px", { "lineHeight": "1.2", "fontWeight": "400" }]
            }
          },
        },
      }
    </script>
<link href="assets/css/custom.css" rel="stylesheet"/>
</head>
