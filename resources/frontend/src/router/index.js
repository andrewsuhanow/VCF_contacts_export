import Vue from 'vue'
import Router from 'vue-router'
import FirstPage from '@/components/FirstPage'
import LoadFilePage from '@/components/LoadFilePage'
import LoadFilePageCardEdit from '@/components/LoadFilePageCardEdit'
import FirstPageCardEdit from '@/components/FirstPageCardEdit'
import StoredPage from '@/components/StoredPage'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/api/FirstPage',
            name: 'FirstPage',
            component: FirstPage,
            props: true,
            children: [
                {
                    path: '/api/FirstPage/:id',
                    name: 'FirstPageCardEdit',
                    component: FirstPageCardEdit,
                    props: true
                }
            ]
        },
        {
            path: '/api/LoadFilePage',
            name: 'LoadFilePage',
            component: LoadFilePage,
            props: true,
            children: [
                {
                    path: '/api/LoadFilePage/:id',
                    name: 'LoadFilePageCardEdit',
                    component: LoadFilePageCardEdit,
                    props: true
                }
            ]
        },
        {
            path: '/api/StoredPage',
            name: 'StoredPage',
            component: StoredPage,
            props: true,
        }

    ]
})
