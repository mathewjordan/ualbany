# VS Page Builder

Page builder utilizing the Advanced Custom Fields 'flexible content' layout. The page build consist of three major parts.
 
- Layouts
- Content
- Elements

### Layouts
Layouts are the top level of the page builder hierarchy. Layouts are used to define a new row and how many columns exist in each row.

### Content
Content are html elements inside of each column. For example a user could select a two column layout. Inside the two column layout
the user would select two types of content; video and wysiwyg. 

The video will render in the left column and the wysiwyg would render on the right column.

### Elements
Elements are the most base level of the page builder. Elements can be used in different content types. For example
the wysiwyg content type contains the option to display a button. The `button` is the reusable element. 
Buttons can always used in other content types, for example stats.


## Dynamic Loading
#### Columns and Content
In order to minimize duplicate code snippets, the column layout elements are dynamically build from a loop.
Each column layout has access to all the content types. Therefore when a new content type is added to the `content` folder
it will be available for all column layout options.

#### Contextualized Includes
Using the php `extract` function content types and element types are loaded without contaminating the global php scope.
Each content type requires a variable called '$temp_key'.

```$xslt
use VS\PageBuilder\Core;

//Example of loading the content type stats
Core\load_content( 'stats', [ 'temp_key' => $temp_key ])
```