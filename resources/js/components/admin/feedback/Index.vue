<template>
    <div id="App" :class="formClass ? 'content-form' : 'content-form hide'">
        <div class="left">
            <div class="bg-white box-shadow">
                <div class="display-flex row space-between border-bottom padding padding-10-px" style="height: 40px;">
                    <div>
                        <h1 class="fonts small black">FEEDBACKS</h1>
                        <p class="fonts micro grey no-line-height">controll your datas</p>
                    </div>
                    <div class="display-flex">
                        <AppButtonMenu 
                            :icon="'fa fa-lw fa-filter'"
                            :button="'btn btn-icon btn-white'"
                            :onChange="(data) => onChangeMenu(data)" 
                            :data="[{label: 'By ID'}, {label: 'By Name'}, {label: 'By Work'}, {label: 'By Status'}]" />
                        <button class="btn btn-white btn-icon btn-radius" @click="onShow('CREATE')">
                            <i class="fa fa-lw fa-plus" />
                        </button>
                        <SearchField :placeholder="'Search feedbacks ..'" style="width: 280px; margin-left: 10px;" />
                    </div>
                </div>
                
                <div class="table-container">
                    <v-table 
                        :data="datas ? datas : []" 
                        :filters="filters" 
                        :currentPage.sync="currentPage" 
                        :pageSize="limitPage" 
                        @totalPagesChanged="totalPages = $event">
                        <thead slot="head">
                            <v-th class="small-col hide-icon">NO</v-th>
                            <v-th sortKey="feedback_id" class="normal-col">Feedback ID</v-th>
                            <v-th sortKey="name">Name</v-th>
                            <v-th sortKey="feedback">Feedback</v-th>
                            <v-th sortKey="status" class="normal-col">Status</v-th>
                            <th class="medium-col"></th>
                        </thead>
                        <tbody slot="body" slot-scope="{displayData}">
                            <AppLoader v-if="visibleLoader" />

                            <tr v-for="(row, index) in displayData" :key="index">
                                <td class="small-col">{{ (index + 1) }}</td>
                                <td class="normal-col">{{ row.feedback_id }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.feedback.substring(0, 50) }} ...</td>
                                <td class="normal-col">
                                    <div 
                                        :class="'card-capsule ' + (row.status === 'active' ? 'active' : '')" 
                                        style="text-transform: capitalize; display: inline-block; padding-top: 2px; padding-bottom: 2px;">
                                        {{ row.status }}
                                    </div>
                                </td>
                                <td class="medium-col">
                                    <div class="display-flex justify-content">
                                        <button class="btn btn-transparent btn-small-icon btn-radius" @click="onShow('EDIT', row.id)">
                                            <i class="fa fa-lw fa-pencil-alt" />
                                        </button>
                                        <button class="btn btn-transparent btn-small-icon btn-radius" @click="onShowHideDelete(row.id)">
                                            <i class="fa fa-lw fa-trash-alt" />
                                        </button>
                                        <button class="btn btn-transparent btn-small-icon btn-radius" @click="onShow('VIEW', row.id)">
                                            <i class="fa fa-lw fa-ellipsis-v" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </div>

                <div class="padding padding-10-px" style="height: 40px;">
                    <smart-pagination
                        :maxPageLinks="5"                       
                        :currentPage.sync="currentPage"
                        :totalPages="totalPages"
                    />
                </div>
            </div>
        </div>

        <div class="right">
            <Form 
                :data.sync="selectedData"
                :message.sync="selectedMessage"
                :title="formTitle" 
                :uploadImage="(data) => uploadImage(data)"
                :removeImage="removeImage"
                :onSave="(data) => onFormSave(data)"
                :onClose="onClose">
            </Form>
        </div>

        <AppAlert 
            v-if="visibleAlertDelete" 
            :isLoader="visibleLoaderAction"
            :title="'This action will remove data permanently, delete this data ?'" 
            :onClose="onShowHideDelete" 
            :onSave="removeData" />
        
        <AppAlert 
            v-if="visibleAlertSave" 
            :isLoader="visibleLoaderAction"
            :title="'Proceed this data ?'" 
            :onClose="onShowHideSave" 
            :onSave="saveData" />
    </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import AppLoader from '../../modules/AppLoader'
import AppAlert from '../../modules/AppAlert'
import SearchField from '../../modules/SearchField'
import AppButtonMenu from '../../modules/AppButtonMenu'
import Form from './Form'

export default {
    name: 'App',
    data () {
        return {
            visibleAlertDelete: false,
            visibleAlertSave: false,
            visibleLoader: false,
            visibleLoaderAction: false,
            formTitle: 'CREATE',
            formClass: false,
            datas: [],
            selectedIndex: null,
            selectedForm: null,
            selectedData: null,
            selectedMessage: null,
            filters: {
                name: { value: '', keys: ['name'] }
            },
            limitPage: 30,
            currentPage: 1,
            totalPages: 0,
            dataUser: null
        }
    },
    mounted () {
        this.dataUser = this.$cookies.get('user')
        this.getData()
    },
    components: {
        AppAlert,
        AppLoader,
        AppButtonMenu,
        SearchField,
        Form
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            token: 'auth/token'
        })
    },
    methods: {
        onChangeMenu (index) {
            console.log('onChange', index)
        },
        nameLength (row) {
            return row.key.length
        },
        onSearchData (id) {
            let payload = null
            this.datas.map((dt) => {
                if (dt.id === id) {
                    payload = {...dt}
                }
                return null 
            })
            return payload
        },
        onSave () {
            this.visibleAlertDelete = false
            this.visibleAlertSave = false
            this.formClass = false
        },
        onClose () {
            this.formClass = false
        },
        onShow (title, index = null) {
            this.formClass = true
            this.formTitle = title
            this.selectedData = index >= 0 ? this.onSearchData(index) : null
            this.selectedMessage = null 
        },
        onShowHideDelete (index = null) {
            this.visibleAlertDelete = !this.visibleAlertDelete
            this.selectedIndex = index
        },
        onShowHideSave () {
            this.visibleAlertSave = !this.visibleAlertSave
        },
        onFormSave (data = null) {
            this.onShowHideSave()
            this.selectedForm = data ? data : null
        },
        onChangeImage (data) {
            this.selectedData = {
                ...this.selectedData,
                image: data
            }
        },
        async removeData () {
            this.visibleLoaderAction = true

            const token = 'Bearer '.concat(this.$cookies.get('token'))
            const id = this.onSearchData(this.selectedIndex).feedback_id
            const payload = {
                feedback_id: id
            }

            const rest = await axios.post('/api/feedback/delete', payload, { headers: { Authorization: token } })

            if (rest && rest.status === 200) {
                this.onShowHideDelete()
                this.onClose()
                this.visibleLoaderAction = false

                const data = rest.data
                if (data.status === 'ok') {
                    this.getData()
                } else {
                    alert('Proceed failed')
                }
            } else {
                alert('Proceed failed')
                this.visibleLoaderAction = false
            }
        },
        async saveData () {
            this.visibleLoaderAction = true

            const token = 'Bearer '.concat(this.$cookies.get('token'))
            const payload = this.selectedForm
            const url = this.formTitle === 'CREATE' ? '/api/feedback/post' : '/api/feedback/update' 

            const rest = await axios.post(url, payload, { headers: { Authorization: token } })

            if (rest && rest.status === 200) {
                this.onShowHideSave()
                this.visibleLoaderAction = false

                const data = rest.data.data
                if (data.length !== 0) {
                    this.onClose()
                    this.getData()
                } else {
                    this.selectedMessage = rest.data.message
                }
            } else {
                alert('Proceed failed')
                this.visibleLoaderAction = false
            }
        },
        async uploadImage (data) {
            this.visibleLoaderAction = true

            const token = 'Bearer '.concat(this.$cookies.get('token'))
            const payload = this.selectedData
            const url = '/api/feedback/uploadImage' 

            let formData = new FormData();
            formData.append('feedback_id', payload.feedback_id);
            formData.append('image', data);

            const rest = await axios.post(url, formData, { headers: { Authorization: token, 'Content-Type': 'multipart/form-data' } })

            if (rest && rest.status === 200) {
                this.visibleLoaderAction = false

                const data = rest.data.data
                if (data && data.image) {
                    this.onChangeImage(data && data.image)
                    this.getData()
                    this.selectedMessage = []
                } else {
                    this.selectedMessage = rest.data.message
                }
            } else {
                alert('Proceed failed')
            }
        },
        async removeImage () {
            this.visibleLoaderAction = true

            const token = 'Bearer '.concat(this.$cookies.get('token'))
            const payload = this.selectedData
            const url = '/api/feedback/removeImage' 

            let formData = new FormData();
            formData.append('feedback_id', payload.feedback_id);

            var a = confirm('remove this image ?')
            if (a) {
                const rest = await axios.post(url, formData, { headers: { Authorization: token, 'Content-Type': 'multipart/form-data' } })

                if (rest && rest.status === 200) {
                    this.visibleLoaderAction = false

                    const data = rest.data.data
                    this.onChangeImage(data && data.image)
                    this.getData()
                } else {
                    alert('Proceed failed')
                }
            }
        },
        async getData () {
            this.visibleLoader = true 

            const token = 'Bearer '.concat(this.$cookies.get('token'))
            const payload = this.dataUser.role_name === 'admin' ? {
                limit: 1000,
                offset: 0
            } : {
                limit: 1000,
                offset: 0,
                user_id: this.dataUser.id
            }
            
            const rest = await axios.post('/api/feedback/getAll', payload, { headers: { Authorization: token } })

            if (rest && rest.status === 200) {
                const data = rest.data.data
                this.datas = data
                this.visibleLoader = false 
            } else {
                this.visibleLoader = false 
            }
        }
    }
}
</script>