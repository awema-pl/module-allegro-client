import { name, version } from '../../package.json'
import plugin from './modules/plugin'
import lang from './modules/lang'
import allegroClientModule from './store/allegro-client'

const awemaPlugin = {

    name, version,

    install(AWEMA) {
        //Vue.use(VueExternalPlugin)
        Vue.use(plugin)

        AWEMA._store.registerModule('allegro-client', allegroClientModule)
        AWEMA.lang = lang
    }
}

if (window && ('AWEMA' in window)) {
    AWEMA.use(awemaPlugin)
} else {
    window.__awema_plugins_stack__ = window.__awema_plugins_stack__ || []
    window.__awema_plugins_stack__.push(awemaPlugin)
}
