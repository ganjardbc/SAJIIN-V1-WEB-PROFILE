<template>
    <div id="admin">
        <div :class="isSidebarSmall ? 'sidebar mobile show' : 'sidebar mobile'">
            <div class="header">
                <div class="header-content display-flex space-between">
                    <router-link :to="{name: 'home'}" class="logo" style="height: 40px; margin-left: 0; margin-top: 0;">
                        <img :src="logo" alt="undang-abi" style="height: 100%;">
                    </router-link>
                    <button class="close btn btn-white btn-icon" @click="onSidebar()">
                        <i 
                            :class="'fa fa-lg fa-times'" 
                            style="font-size: 18px; margin-top: 0;" />
                    </button>
                </div>
            </div>
            <div class="content">
                <AppListMenu :data.sync="sidebar" />
            </div>
        </div>
        <div class="main">
            <div class="header">
                <div class="set-padding display-flex space-between">
                    <div class="display-flex">
                        <button class="show-on-mobile btn btn-sekunder btn-icon" style="margin-right: 5px;" @click="onSidebar()">
                            <i 
                                :class="'fa fa-lg fa-bars'" 
                                style="font-size: 18px; margin-top: 0;" />
                        </button>
                    </div>
                    <div style="width: 100%;" class="display-flex right">
                        <router-link :to="{name: 'profile'}" class="card-small-profile" style="margin-left: 5px;">
                            <div class="image" style="text-align: center;">
                                <i class="post-top fa fa-lw fa-user-circle" style="color: #999;" />
                            </div>
                            <div class="label" style="text-transform: uppercase;">{{ user && user.name }}</div>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="content">
                <router-view />
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import AppListMenu from '../modules/AppListMenu'
import logo from '../../../img/logo.png'

const sidebarAdmin = [
    {icon: 'fa fa-lg fa-database', label: 'MASTERDATA', value: 0, menu: [
        {icon: 'fa fa-lg fa-list-ol', label: 'Categories', value: 0, link: 'category', permission: 'categories'},
        {icon: 'fa fa-lg fa-newspaper', label: 'Articles', value: 0, link: 'article', permission: 'articles'},
    ]},
    {icon: 'fa fa-lg fa-database', label: 'USER N ROLES', value: 0, menu: [
        {icon: 'fa fa-lg fa-lock', label: 'Permissions', value: 0, link: 'permission', permission: 'permissions'},
        {icon: 'fa fa-lg fa-flag', label: 'Roles', value: 0, link: 'role', permission: 'roles'},
        {icon: 'fa fa-lg fa-user', label: 'Users', value: 0, link: 'user', permission: 'users'}
    ]}
]

export default {
    name: 'admin',
    metaInfo: {
        title: 'Saji-in',
        titleTemplate: '%s | Admin Panel',
        htmlAttrs: {
            lang: 'en',
            amp: true
        }
    },
    data () {
        return {
            permissions: null,
            logo: logo,
            sidebar: null,
            isSidebarSmall: false,
            classSidebar: 'sidebar smalls',
            classSidebarMenu: 'menu-list hover with-icon smalls'
        }
    },
    mounted () {
        const permissions = this.$cookies.get('permissions')
        this.permissions = permissions.permissions
        this.onCheckMenus(sidebarAdmin)
    },
    components: {
        AppListMenu
    },
    methods: {
        ...mapActions({
            getCount: 'cart/getCount',
            getCountOrder: 'order/getCount'
        }),
        onCheckSubmenus (data) {
            let menu = []
            data && data.map((dt) => {
                const stt = this.onCheckPermission(dt.permission)
                if (stt) {
                    menu.push({
                        ...dt
                    })
                }
            })
            return menu
        },
        onCheckMenus (data) {
            let menu = []
            data && data.map((dt) => {
                if (dt.menu) {
                    let submenu = this.onCheckSubmenus(dt.menu)
                    if (submenu.length > 0) {
                        let submenuPayload = []
                        submenu && submenu.map((sb) => {
                            submenuPayload.push({...sb})
                        })
                        if (submenuPayload.length > 0) {
                            menu.push({
                                ...dt,
                                menu: submenuPayload
                            })
                        }
                    }
                }
            })
            this.sidebar = menu
        },
        onCheckPermission (prm) {
            let stt = false
            const data = this.permissions
            data && data.map((dt) => {
                if (dt.permission_name === prm) {
                    stt = true
                }
            })
            return stt
        },
        onSetNotif (target, notif) {
            const data = this.sidebar
            data && data.map((dt, i) => {
                dt.menu && dt.menu.map((sb, j) => {
                    if (sb.permission === target) {
                        this.sidebar[i].menu[j].value = notif
                    }
                })
            })
        },
        onSidebar () {
            this.isSidebarSmall = !this.isSidebarSmall
        },
        getLocalCartCount () {
            const token = 'Bearer '.concat(this.$cookies.get('token'))
            this.getCount(token)
        },
        getLocalOrderCount () {
            const token = 'Bearer '.concat(this.$cookies.get('token'))
            this.getCountOrder(token)
        }
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            token: 'auth/token',
            cart: 'cart/count',
            carts: 'cart/all',
            order: 'order/count',
            orders: 'order/all'
        })
    },
    watch: {
        orders (props) {
            let val = 0
            const data = this.$cookies.get('user')
            const role = data && data.role_name
            switch (role) {
                case 'admin':
                    val = props.allAdmin
                    break;
                default:
                    val = props.all
                    break;
            }

            this.onSetNotif('orders', val)
        },
        carts (props) {
            let val = 0
            const data = this.$cookies.get('user')
            const role = data && data.role_name
            switch (role) {
                case 'admin':
                    val = props.allAdmin
                    break;
                default:
                    val = props.all
                    break;
            }
            this.onSetNotif('carts', val)
        }
    }
}
</script>