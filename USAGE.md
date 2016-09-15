eZ Platform Site API usage instructions
=======================================

Basic usage
-----------

Site API provides a complete overhaul of the way you write your code. However, you can start using `LoadService` and `FindService` instead of eZ Platform's `SearchService`, `LocationService` and `ContentService` by rewriting your custom services piece by piece, while at the same time, keeping your controllers and Twig templates using the old code. This way, you don't have to rewrite your templates and custom controllers the moment you install Site API.

Full view templates and controllers
-----------------------------------

Once you're ready to rewrite your controllers and templates, you can activate the Site API with the following config:

```yml
netgen_ez_platform_site_api:
    system:
        frontend_group:
            override_url_alias_view_action: true
```

where `frontend_group` is the group (or siteaccess) for which you want to activate the site API. This switch is useful if you have some siteaccesses which can't use site API, like custom admin or intranet interfaces.

From the moment you turn this switch on, all your full view templates and full view controllers will need to use Site API to keep on functioning. `content` and `location` variables inside Twig templates will be instances of Site API `Content` and `Location` value objects, `$view` variable passed to your custom controllers will be an instance of Site API `ContentView` variable, and so on.

Other views
-----------

You will need to replace calls to `ez_content:viewAction` controller subrequest with `ng_content:viewAction`. This will make sure that your views other than full view (line, listitem, embed and so on) also use the Site API.

Twig functions
--------------

You will also need to remove all calls to `ez_*` Twig functions that use the original `Content` value objects, and replace them with Site API compatible ones:

* `ng_render_field(content.fields.title)` instead of `ez_render_field(content, 'title')`
* `content.fields.title` instead of `ez_field(content, 'title')`
* `ng_image_alias(content.fields.image, 'large')` instead of `ez_image_alias(ez_field(content, 'image'), content.versionInfo, 'large')`
* `content.fields.image.empty` instead of `ez_is_field_empty(content, 'image')`
* `content.fields.publish_date.value` instead of `ez_field_value(content, 'publish_date')`
* `content.name` instead of `ez_content_name(content)`

If you want to keep using `ez_*` Twig functions, you can, since you have access to original `Content` and `Location` value objects with `content.innerContent` and `location.innerLocation`.