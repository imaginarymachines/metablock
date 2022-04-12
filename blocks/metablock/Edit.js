import { TextControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";
import { InspectorControls } from "@wordpress/block-editor";
import { useSelect, useDispatch } from "@wordpress/data";
import { useEffect } from "@wordpress/element";

import "./editor.scss";

export default function Edit({ attributes, setAttributes, isSelected }) {
	//Get meta value
	const { meta } = useSelect((select) => ({
		meta: select("core/editor").getEditedPostAttribute("meta"),
	}));
	//Updates meta value
	const { editPost } = useDispatch("core/editor");
	const setMeta = (keyAndValue) => {
		editPost({ meta: keyAndValue });
	};

	//Get attribute values
	const { field_name, field_value } = attributes;

	//Update field_name
	const setFieldName = (value) => {
		setAttributes({ ...attributes, field_name: value });
	};

	//Update field_value
	const setFieldValue = (newValue) => {
		setMeta({ [field_name]: newValue });
		setAttributes({ ...attributes, field_value: newValue });
	};

	//Re-set attribute to meta value
	//Meta value may have change since last load
	useEffect(() => {
		if (meta[field_name] !== undefined) {
			setAttributes({ ...attributes, field_value: meta[field_name] });
		}
	}, []);

	return (
		<div {...useBlockProps()}>
			<InspectorControls>
				<TextControl
					label={__("Field Name")}
					onChange={setFieldName}
					value={field_name}
				/>
				{field_name.length > 0 ? (
					<TextControl
						label={__("Field Value")}
						onChange={setFieldValue}
						value={field_value}
					/>
				) : null}
			</InspectorControls>
			{field_value ? <p>{field_value}</p> : <p>No value</p>}
		</div>
	);
}
