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
				label: "-- Select Parent --",
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
			cat,
			tag,
			tag_show,
			layout,
			column,
			orderby,
			perpage,
			popup,
		} = attributes;

		const categories = this.getCategoriesTree();

		function onChangeTag(content) {
			setAttributes({ tag: content });
		}

		function onChangeColumn(changes) {
			setAttributes({ column: changes });
		}

		function onChangePerpage(changes) {
			setAttributes({ perpage: changes });
		}

		function toggleAttribute(attribute) {
			return (newValue) => {
				setAttributes({ [attribute]: newValue });
			};
		}

		return (
			<Fragment>
				<div className={className}>
					<InspectorControls>
						<PanelBody title={__("Category & Tags", "flexi")}>
							<SelectControl
								label="Select Category"
								value={cat}
								options={categories}
								onChange={(value) => setAttributes({ cat: Number(value) })}
							/>

							<TextControl
								label="Tag name separated by commas"
								value={tag}
								onChange={onChangeTag}
							/>
							<ToggleControl
								label="Display tags above gallery"
								checked={tag_show}
								onChange={toggleAttribute("tag_show")}
							/>

							<SelectControl
								label="Order By"
								value={orderby}
								options={[
									{
										label: "Title",
										value: "title",
									},
									{
										label: "Date",
										value: "date",
									},
									{
										label: "Modified Date",
										value: "modified",
									},
									{
										label: "Flexi ID",
										value: "id",
									},
									{
										label: "Random",
										value: "rand",
									},
								]}
								onChange={(value) => setAttributes({ orderby: value })}
							/>
						</PanelBody>
						<PanelBody title={__("Layout Controls", "flexi")}>
							<SelectControl
								label="Layout"
								value={layout}
								options={[
									{
										label: "Masonry",
										value: "masonry",
									},
									{
										label: "Regular",
										value: "regular",
									},
									{
										label: "Wide",
										value: "wide",
									},
								]}
								onChange={(value) => setAttributes({ layout: value })}
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
						</PanelBody>
					</InspectorControls>

					<ServerSideRender
						block="cgb/block-flexi-block"
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
