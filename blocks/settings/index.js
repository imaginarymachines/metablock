import { __ } from "@wordpress/i18n";
import { PanelBody } from "@wordpress/components";
import { PluginSidebar } from "@wordpress/edit-post";
import { key } from "@wordpress/icons";
import { registerPlugin } from "@wordpress/plugins";
import { useSelect, useDispatch } from "@wordpress/data";
import { TextControl } from "@wordpress/components";
const SideBar = () => {
	//Get meta value
	const { something } = useSelect((select) =>
		select("core/editor").getEditedPostAttribute("meta")
	);

	//Get updater for meta
	const { editPost } = useDispatch("core/editor", [something]);

	const setMeta = (keyAndValue) => {
		editPost({ meta: keyAndValue });
	};

	return (
		<PluginSidebar name="settings" title={__("Metablock Settings")} icon={key}>
			<PanelBody>
				<TextControl
					value={something}
					label={__("Something")}
					onChange={(newValue) => {
						editPost({
							meta: {
								something: newValue,
							},
						});
					}}
				/>
			</PanelBody>
		</PluginSidebar>
	);
};

registerPlugin("settings", {
	render: SideBar,
});
