import Layouts from "./layouts.js";
import Defaults from "./defaults.js";

export function ChangeLayout(layout, module, data) {
    document.getElementById('app').innerHTML = layout;
    module();
}