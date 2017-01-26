# SizeMe for Magento

SizeMe is a service designed to help you provide better product information for your customers.  
With SizeMe you can enter the actual measurements of your product and show an actual Size Guide.  
Or you might already find the measurements of the product you are selling in our ever-growing
hosted Product Database.  

Your users can enter their own physical measurements and get personal information
on how the viewed item will fit them.  

[https://www.sizeme.com](https://www.sizeme.com/)

## Installation notes:

## Product information:
SizeMe needs certain product information to function in the first place.  Basically we use a product item type definition and some measurements from each size of the product.  SizeMe offers two different ways of including this information; you can send your item measurement data to us and use the SizeMe Product Database _or_ you can use the store's own database to store the necessary measurements.

1.  Using the SizeMe Product Database
SizeMe needs at least one measurement per item.  In some cases (like shoes) only one measurement is actually needed to give a good estimate of personal fit.  We have a hosted Product Database and we would be more than happy to host your product measurements for you.  Just send the product measurement data in any format to us, and we'll handle the data and your item measurement data will be made available.  There is also a good possibility that we also have measurements from the products you are selling (we already have most a lot shoe measurements for example), so you might want to contact us before submitting any product data.

We use the product SKU fields to match the products in the store to your measurement data, so please send the SKU data along with the measurement data.

2.  Using the Store Database
The installation creates a new attribute set called "SizeMe Item".  This set includes all the product fields needed to store the product information in your store and show it on the product page.  The attribute set can be found at its own tab in the Product Information page.  

The required product information is a little different on _configurable_ and _simple_ products.  

### Configurable product 
The configurable product should hold the common SizeMe information for the whole product.  These fields are:

#### Item Type
This code is used to tell SizeMe what the type of the product is.  Please see [the full reference](http://example.com).
* Type: string, 7-digit dot-separated code
  Examples:
  * Normal short sleeved T-shirt: 1.1.1.3.0.4.0
  * Sweatshirt with hood: 1.3.1.6.1.4.1
  * Trousers: 2.0.0.6.0.3.0
  * Shoes: 3.0.0.0.0.0.0

#### Item Layer
This code tells on what layer is the product to be worn on. 
* 0 (zero) is directly on skin, 
* 1 is with one layer underneath (like a hoodie, trousers or shoes)
* 2 is with two layers underneath (like coats or such)
* Type: number (integer)

#### Item Thickness
Enter the average item thickness here in millimeters [mm].  The item measurements are given on the outside of the item (except for shoes), so item thickness is needed to calculate the inner measurement.
* Type: number (integer)

#### Item Stretch
This value tells SizeMe how much this item can stretch.  The value is stretch percentage value as an integer, so if an item stretches 20 % when stretched, then this value is marked as 20.  The way we measure the stretch value is by simply stretching the item by hand using a sensible amount of force and see how much the item stretches.  We usually grab the item over a ruler with hands 10 cm apart, and then stretch the item and read the stretched value from the ruler.  If your hands are 14 cm apart after stretching, then the stretch value in the Item Stretch field would be 40 (as in +40 % you know).  
* Type: number (integer)

If no product information for the product is available, the SizeMe integration doesn't really do much.  

### Simple product 
The simple products, which are the single sizes (or size and color combinations) of the item, hold the physical measurements of each size.  All measurements are measured __flat__ across the outside of the unstretched item unless otherwise noted.  All measurements are stored in millimeters [mm].  

#### Measurements fields
* Chest
* Waist
* Sleeve
* Sleeve top width
* Wrist width
* Underbust
* Neck opening width
* Shoulder width
* Front height
* Pant waist
* Hips
* Inseam
* Outseam
* Thigh width
* Knee width
* Calf width
* Pant sleeve width 
* Shoe inside length (mesaured on the inside)
* Shoe inside width (not supported yet)
* Hat width
* Hood height

## Configuration: 

### General:

#### Service status
There are three options for this value: On, Test and Off.  
* "On" means that the service is live normally.  A SizeMe splash welcome is included for non-SizeMe users and SizeMe users are recognized automatically.
* "Test" means that a special test version of the service is active.  Existing SizeMe users 
* "Off" means that no SizeMe functionality is included in your store.  
Default value: Off

#### Change Size Selection to Buttons
This is a bit of a bonus feature.  If this value is set to "Yes" and the service is "On" or "Test", the plugin will try to convert your size selection drop-down to a set of clickable buttons.  This currently doesn't work with products with multiple selections (such as color _and_ size).
Default value: No

### Template Settings: 

#### Replace Configurable Product Option Template
By default the plugin adds a certain class (".sizeme-magento-size-selector") to the correct size selector on the product page.  Many themes like to use their own custom file to write the configurable product page, and in those cases you might want to change this option to "No".  If this is set to "No", you just have to change the SizeMe Size Selection Element (in UI Options Overrides) to point to the correct size selection element.
Default value: Yes

### Attribute Settings: 

#### Product Size Attributes
Use this multiselect to select the size attribute, so that SizeMe knows which one to follow.  You can select multiple values (by pressing Ctrl while selecting) if you have multiple size attributes.  This option is only active if the "Replace Configurable Product Option Template" is set to "Yes".

### UI Options Overrides:

The plugin is pre-configured to work in default Magento themes.  However, if you have a custom theme installed in your store, you might have to override some of the default values with which SizeMe interacts with the product page.  Only include the values you want to override, otherwise default values will be used.
  
SizeMe uses the jQuery library to interact with the product page.  

#### Append SizeMe Content To This Element 
This selector is used to identify where SizeMe appends the SizeMe content (Sizing bar, Size Guide and Detailed View buttons)
* Type: jQuery selector
* Default: .product-options

#### Append SizeMe Splash To This Element
This selector is used to identify where SizeMe appends the SizeMe content (Sizing bar, Size Guide and Detailed View buttons)
* Type: jQuery selector
* Default: .product-options

#### SizeMe Size Selection Element
This selector is used to identify where the size selector element to SizeMe.  The default value uses the class `sizeme-magento-size-selector` which is written by the plugin according to the size attribute selection in SizeMe -> Attribute Settings -> Product Size Attributes
* Type: jQuery selector
* Default: select.sizeme-magento-size-selector

#### Invoke Element
This selector is used to identify which element(s) to listen to for changes that might affect the size selector and thus, SizeMe.  This element could basically be the same as the size selector, but in product pages with multiple selections such as size __and__ color, you have to listen to all the select elements.  
* Type: jQuery selector
* Default: select.super-attribute-select

#### Invoke Event
This value is used to identify which event to listen to for changes as outlined in the Invoke Element definition.
* Type: jQuery event
* Default: change

#### Add To Cart Button Element
This selector is used to identify the correct Add To Cart element.  The default value uses two different values due to some legacy thing.
* Type: jQuery selector
* Default: form#product_addtocart_form a.liftup-button, form#product_addtocart_form button

#### Add To Cart Event
This value is used to identify the correct Add To Cart event.
* Type: jQuery event
* Default: click

#### Switch Selected Size to Recommended on Page Load
SizeMe will automatically try to select the best fitting size on product page load.  Sometimes, this might be impossible due to the dynamic nature of the selectors or something.  
* Type: boolean (true/false)
* Default: true

#### Language Code Override
Usually SizeMe will try to sniff the store language from the html tags lang parameter.  This value can be used to override this sniffing.  SizeMe uses ISO 639-1 language codes and will default to English if the given language is not supported.
* Type: ISO 639-1 language code
* Default: sniffed from code

#### Custom Style Overrides
This text field can be used to write some custom CSS to the head of the page.  This is one opportunity to make changes to the SizeMe user interface, you can change the colors and stuff like that.
* Type: CSS code
* Default: defined in sizeme-magento.css










