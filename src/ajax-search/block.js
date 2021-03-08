/**
 * BLOCK: custom-blocks
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import "./editor.scss";
import "./style.scss";

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

/**
 * Register: a Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType("mwd/ajax-search", {
    // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
    title: __("Ajax Search"), // Block title.
    icon: "search", // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
    category: "common", // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
    keywords: [__("search"), __("search block"), __("ajax search"), __("mwd")],

    attributes: {
        postTypes: {
            type: "array",
        },
        selectedType: {
            type: "string",
            default: "All",
        },
    },

    /**
     * The edit function describes the structure of your block in the context of the editor.
     * This represents what the editor will render when the block is used.
     */
    edit: ({ attributes, setAttributes }) => {
        if (!attributes.postTypes) {
            wp.apiFetch({
                url: "/wp-json/wp/v2/types",
            }).then((postTypes) => {
                let arrayConversion = Object.values(postTypes);
                let filteredTypes = arrayConversion.filter((type) => {
                    return type.name == "Media" ||
                        type.name == "Reusable Blocks"
                        ? false
                        : true;
                });
                return setAttributes({
                    postTypes: filteredTypes,
                });
            });
        }

        console.log(attributes.postTypesData);

        if (!attributes.postTypes) {
            return "Loading...";
        }

        return (
            <div className="container">
                <div className="form-row">
                    <label htmlFor="select">Select Post Type</label>
                    <select
                        className="select"
                        onChange={(e) =>
                            setAttributes({ selectedType: e.target.value })
                        }
                        value={attributes.selectedType}>
                        <option value="all">All</option>
                        {attributes.postTypes.map((type, idx) => {
                            return (
                                <option value={type.name} key={idx}>
                                    {type.name.charAt(0).toUpperCase() +
                                        type.name.slice(1)}
                                </option>
                            );
                        })}
                    </select>
                </div>
                <div className="form-row">
                    {/* <label htmlFor="input">Posts Per Page</label>
                    <input
                        type="text"
                        onChange={(e) =>
                            setAttributes({ postsPerPage: e.target.value })
                        }
                        value={attributes.postsPerPage}
                    /> */}
                </div>
            </div>
        );
    },

    /**
     * The save function defines the way in which the different attributes should be combined
     * into the final markup, which is then serialized by Gutenberg into post_content.
     */
    save: () => null,
});
