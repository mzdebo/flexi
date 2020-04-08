/**
 * BLOCK: flexi-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import "./editor.scss";
import "./style.scss";

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType, RichText } = wp.blocks; // Import registerBlockType() from wp.blocks
const {
	ColorPalette,
	AlignmentToolbar,
	BlockControls,
	BlockAlignmentToolbar,
	InspectorControls,
} = wp.editor;
const {
	Toolbar,
	Button,
	Text,
	Tooltip,
	PanelBody,
	PanelRow,
	FormToggle,
	SelectControl,
	ToggleControl,
	ServerSideRender,
	TextControl,
	Disabled,
	RangeControl,
} = wp.components;

const { Component, Fragment } = wp.element;
const { withState } = wp.compose;

/**
 * Register: aa Gutenberg Block.
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
registerBlockType("cgb/block-flexi-block", {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __("flexi-block - x1 Block"), // Block title.
	icon: "shield", // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: "common", // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__("flexi-block — x1 Block"),
		__("xxx Example"),
		__("create-guten-block"),
	],
	attributes: {
		layout: {
			type: "string",
			default: "regular",
		},
		column: {
			type: "number",
			default: 2,
		},
		perpage: {
			type: "number",
			default: 10,
		},
		popup: {
			type: "boolean",
			default: false,
		},
		orderby: {
			type: "string",
			default: "asc",
		},
	},

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Component.
	 */
	edit: function (props) {
		const { setAttributes, attributes, className, focus } = props;
		var column = props.attributes.column;
		var perpage = props.attributes.perpage;
		var layout = props.attributes.layout; // To bind attribute layout
		var popup = props.attributes.popup; // To bind attribute layout
		var orderby = props.attributes.orderby; // To bind attribute layout

		function onChangeLayout(content) {
			props.setAttributes({ layout: content });
		}

		function onChangeColumn(changes) {
			props.setAttributes({ column: changes });
		}

		function onChangePerpage(changes) {
			props.setAttributes({ perpage: changes });
		}

		function toggleAttribute(attribute) {
			return (newValue) => {
				props.setAttributes({ [attribute]: newValue });
			};
		}

		return [
			<Fragment>
				<div className={props.className}>
					<InspectorControls>
						<PanelBody title={__("Settings One")} initialOpen={true}>
							<TextControl
								label="Input text"
								value={layout}
								onChange={onChangeLayout}
							/>
							<RangeControl
								label="Columns"
								value={column}
								onChange={onChangeColumn}
								min={1}
								max={10}
							/>
							<RangeControl
								label="Post Per Page"
								value={perpage}
								onChange={onChangePerpage}
								min={1}
								max={100}
							/>

							<ToggleControl
								label="Popup"
								checked={popup}
								onChange={toggleAttribute("popup")}
							/>

							<SelectControl
								label="Order By"
								value={orderby}
								options={[
									{
										label: "Ascending by Title",
										value: "asc",
									},
									{
										label: "Descending by Title",
										value: "desc",
									},
								]}
								onChange={(value) => setAttributes({ orderby: value })}
							/>
						</PanelBody>
					</InspectorControls>

					<Disabled>
						<ServerSideRender
							block="cgb/block-flexi-block"
							attributes={attributes}
						/>
					</Disabled>
				</div>
			</Fragment>,
		];
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Frontend HTML.
	 */
	save: (props) => {
		//props.attributes.button_color //This way get attribute value
		return null;
	},
});
