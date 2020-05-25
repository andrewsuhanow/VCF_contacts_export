import Vue from 'vue'
import App from './App.vue'

import router from './router'
import vuetify from './plugins/vuetify';




import Vuetify from 'vuetify'
Vue.use(Vuetify)
import 'vuetify/dist/vuetify.min.css'



Vue.config.productionTip = false

new Vue({
    render: h => h(App),
    vuetify,
    router,
    icons: {
        iconfont: 'mdiSvg',
    },
}).$mount('#app')
