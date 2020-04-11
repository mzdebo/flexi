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
			button_label,
			category_label,
			tag_label,
			desp_label,
			desp_placeholder,
			enable_category,
			enable_tag,
			enable_desp,
			enable_file,
			enable_bulk_file,
			file_label,
			enable_security,
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
						<PanelBody
							title={__("Description Field", "flexi")}
							initialOpen={false}
						>
							<ToggleControl
								label="Enable Description"
								checked={enable_desp}
								onChange={toggleAttribute("enable_desp")}
							/>

							<TextControl
								label="Description Title"
								value={desp_label}
								onChange={toggleAttribute("desp_label")}
							/>
							<TextControl
								label="Description Placeholder"
								value={desp_placeholder}
								onChange={toggleAttribute("desp_placeholder")}
							/>
						</PanelBody>
						<PanelBody
							title={__("Category Field", "flexi")}
							initialOpen={false}
						>
							<ToggleControl
								label="Enable Category"
								checked={enable_category}
								onChange={toggleAttribute("enable_category")}
							/>

							<TextControl
								label="Category Title"
								value={category_label}
								onChange={toggleAttribute("category_label")}
							/>
						</PanelBody>
						<PanelBody title={__("Tag Field", "flexi")} initialOpen={false}>
							<ToggleControl
								label="Enable Tag"
								checked={enable_tag}
								onChange={toggleAttribute("enable_tag")}
							/>
							<TextControl
								label="Tag Title"
								value={tag_label}
								onChange={toggleAttribute("tag_label")}
							/>
						</PanelBody>
						<PanelBody
							title={__("File Attach Field", "flexi")}
							initialOpen={false}
						>
							<ToggleControl
								label="Enable File Upload"
								checked={enable_file}
								onChange={toggleAttribute("enable_file")}
							/>
							<ToggleControl
								label="Enable Bulk File Upload"
								checked={enable_bulk_file}
								onChange={toggleAttribute("enable_bulk_file")}
							/>
							<TextControl
								label="Upload Title"
								value={file_label}
								onChange={toggleAttribute("file_label")}
							/>
						</PanelBody>
						<PanelBody
							title={__("Security reCaptcha Field", "flexi")}
							initialOpen={false}
						>
							<ToggleControl
								label="Enable Google reCaptcha"
								checked={enable_security}
								onChange={toggleAttribute("enable_security")}
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
