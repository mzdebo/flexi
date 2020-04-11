// Import block dependencies and components
import { BuildTree, GroupByParent } from "../helper.js";
// Components
const {
	Disabled,
	PanelBody,
	RangeControl,
	SelectControl,
	ServerSideRender,
	ToggleControl,
	TextControl,
} = wp.components;
const { __ } = wp.i18n; // Import __() from wp.i18n
const { Component, Fragment } = wp.element;

const { InspectorControls } = wp.editor;

const { withSelect } = wp.data;

/**
 * Create an FlexiGalleryEdit Component.
 */
class FlexiGalleryEdit extends Component {
	constructor() {
		super(...arguments);
		this.toggleAttribute = this.toggleAttribute.bind(this);
	}

	getCategoriesTree() {
		const { categoriesList } = this.props;

		let categories = [
			{
				label: "-- Select All --",
				value: 0,
			},
		];

		if (categoriesList && categoriesList.length > 0) {
			let grouped = GroupByParent(categoriesList);
			let tree = BuildTree(grouped);

			categories = [...categories, ...tree];
		}

		return categories;
	}

	toggleAttribute(attribute) {
		return (newValue) => {
			this.props.setAttributes({ [attribute]: newValue });
		};
	}

	render() {
		const { attributes, setAttributes, className } = this.props;

		const {
			enable_ajax,
			form_class,
			form_title,
			title_label,
			title_placeholder,
		} = attributes;

		const categories = this.getCategoriesTree();

		function toggleAttribute(attribute) {
			return (newValue) => {
				setAttributes({ [attribute]: newValue });
			};
		}

		return (
			<Fragment>
				<div className={className}>
					<InspectorControls>
						<PanelBody title={__("Form Settings", "flexi")} initialOpen={false}>
							<ToggleControl
								label="Enable Ajax Submission"
								checked={enable_ajax}
								onChange={toggleAttribute("enable_ajax")}
							/>

							<TextControl
								label="Internal Form Title"
								value={form_title}
								onChange={toggleAttribute("form_title")}
							/>

							<SelectControl
								label="Form Class Style"
								value={form_class}
								options={[
									{
										label: "Stacked",
										value: "pure-form pure-form-stacked",
									},
								]}
								onChange={(value) => setAttributes({ form_class: value })}
							/>
						</PanelBody>
						<PanelBody title={__("Title Field", "flexi")} initialOpen={false}>
							<TextControl
								label="Label of Form Title"
								value={title_label}
								onChange={toggleAttribute("title_label")}
							/>
							<TextControl
								label="Title Placeholder"
								value={title_placeholder}
								onChange={toggleAttribute("title_placeholder")}
							/>
						</PanelBody>
						<PanelBody title={__("Submit Button", "flexi")} initialOpen={false}>
							<TextControl
								label="Label of Submit Button"
								value={button_label}
								onChange={toggleAttribute("button_label")}
							/>
						</PanelBody>
					</InspectorControls>

					<ServerSideRender
						block="cgb/block-flexi-block-form"
						attributes={attributes}
					/>
				</div>
			</Fragment>
		);
	}
}

export default withSelect((select) => {
	const { getEntityRecords } = select("core");

	const categoriesListQuery = {
		per_page: 100,
	};

	return {
		categoriesList: getEntityRecords(
			"taxonomy",
			"flexi_category",
			categoriesListQuery
		),
	};
})(FlexiGalleryEdit);
