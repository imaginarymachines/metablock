import { TextControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";
import { InspectorControls } from "@wordpress/block-editor";
import { useSelect, useDispatch } from "@wordpress/data";

import "./editor.scss";

export default function Edit({ attributes, setAttributes, isSelected }) {
	//Get meta value

	const { meta } = useSelect((select) => ({
		meta: select("core/editor").getEditedPostAttribute("meta"),
	}));
	const { editPost } = useDispatch("core/editor");

	const setMeta = (keyAndValue) => {
		editPost({ meta: keyAndValue });
	};

	const { field_name } = attributes;
	const setFieldName = (value) => {
		setAttributes({ field_name: value });
	};

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
						onChange={(newValue) => setMeta({ [field_name]: newValue })}
						value={meta && meta[field_name] ? meta[field_name] : ""}
					/>
				) : null}
			</InspectorControls>
			{meta && meta[field_name] ? <p>{meta[field_name]}</p> : <p>No value</p>}
		</div>
	);
}
