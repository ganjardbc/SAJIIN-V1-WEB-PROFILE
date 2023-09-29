<template>
    <div id="AppGridMenu">
        <ul :class="`content-scroll menu-grid hover with-list-icon`">
            <li 
                v-for="(dt, index) in dataSideBar" 
                :key="index" 
                :class="'ml-grid'"
                @click="onClickMenu"
            >
                <el-tooltip 
                    class="item" 
                    effect="dark" 
                    :content="dt.label"
                    :disabled="true" 
                    placement="right">
                    <router-link 
                        :to="dt.link" 
                        class="ml-link">
                        <div class="ml-icon">
                            <i :class="dt.icon" />
                        </div>
                        <div class="ml-label">
                            {{ dt.label }}
                        </div>
                        <div class="val-container">
                            <div v-if="dt.value > 0" class="ml-value">
                                <div class="post-center">{{ dt.value }}</div>
                            </div>
                        </div>
                    </router-link>
                </el-tooltip>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    name: 'AppGridMenu',
    data () {
        return {
            permissions: [],
            sidebar: [],
        }
    },
    mounted() {
        // const permissions = this.$cookies.get('permissions')
        const permissions = {
            permissions: [
                {'permission_name': 'dashboard'}
            ]
        }
        this.permissions = permissions.permissions
    },
    methods: {
        onClickMenu () {
            this.$emit('onClickMenu')
        },
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
    },
    computed: {
        dataSideBar() {
            let menu = []
            this.data && this.data.map((dt) => {
                menu.push({ ...dt })
                // if (dt.menu) {
                //     let submenu = this.onCheckSubmenus(dt.menu)
                //     if (submenu.length > 0) {
                //         let submenuPayload = []
                //         submenu && submenu.map((sb) => {
                //             submenuPayload.push({...sb})
                //         })
                //         if (submenuPayload.length > 0) {
                //             menu.push({
                //                 ...dt,
                //                 menu: submenuPayload
                //             })
                //         }
                //     }
                // }
            })
            return menu
        }
    },
    props: {
        onPress: {
            default: null,
            required: false
        },
        enableGridView: {
            type: Boolean,
            required: false
        },
        disableResponsive: {
            type: Boolean,
            required: false
        },
        isSidebarSmall: {
            type: Boolean,
            required: false
        },
        data: {
            required: true
        }
    }
}
</script>