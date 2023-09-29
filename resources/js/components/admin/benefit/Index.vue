<template>
    <div id="App" :class="formClass ? 'content-form' : 'content-form hide'">
        <div class="left">
            <div class="bg-white box-shadow">
                <div class="display-flex row space-between border-bottom padding padding-10-px" style="height: 40px;">
                    <div>
                        <h1 class="fonts small black">BENEFITS</h1>
                        <p class="fonts micro grey no-line-height">controll your datas</p>
                    </div>
                    <div class="display-flex">
                        <AppButtonMenu 
                            :icon="'fa fa-lw fa-filter'"
                            :button="'btn btn-icon btn-white'"
                            :onChange="(data) => onChangeMenu(data)" 
                            :data="[{label: 'By ID'}, {label: 'By Title'}, {label: 'By Status'}]" />
                        <button class="btn btn-white btn-icon btn-radius" @click="onShow('CREATE')">
                            <i class="fa fa-lw fa-plus" />
                        </button>
                        <SearchField :placeholder="'Search benefits ..'" style="width: 280px; margin-left: 10px;" />
                    </div>
                </div>
                
                <div class="table-container">
                    <el-table
                        :data="datas ? datas : []"
                        empty-text="No Data"
                        style="width: 100%">
                        <el-table-column
                            type="index"
                            width="60"
                            :index="indexMethod">
                        </el-table-column>
                        <el-table-column
                            label="Benefit ID">
                            <template slot-scope="scope">
                                <div>{{ scope.row.benefit_id }}</div>
                            </template>
                        </el-table-column>
                        <el-table-column
                            label="Title">
                            <template slot-scope="scope">
                                <div>{{ scope.row.title }}</div>
                            </template>
                        </el-table-column>
                        <el-table-column
                            label="Status"
                            width="150">
                            <template slot-scope="scope">
                                <div class="display-flex">
                                    <div 
                                        :class="`card-capsule ${scope.row.status === 'active' && 'active'}`" 
                                        style="text-transform: capitalize; line-height: 0.6;">
                                        {{ scope.row.status }}
                                    </div>
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column
                            width="100">
                            <template slot-scope="scope">
                                <el-popover
                                    placement="bottom-end"
                                    width="180"
                                    trigger="click">
                                    <div class="width width-100">
                                        <button 
                                            class="btn btn-white btn-full btn-align-left"
                                            @click="onShow('VIEW', scope.row.id)">
                                            <i class="icn icn-left fa fa-lw fa-align-left"></i> Detail
                                        </button>
                                        <button 
                                            class="btn btn-white btn-full btn-align-left"
                                            @click="onShow('EDIT', scope.row.id)">
                                            <i class="icn icn-left fa fa-lw fa-edit"></i> Edit 
                                        </button>
                                        <button 
                                            class="btn btn-white btn-full btn-align-left"
                                            @click="onShowHideDelete(scope.row.id)">
                                            <i class="icn icn-left fa fa-lw fa-trash-alt"></i> Delete
                                        </button>
                                    </div>
                                    <button 
                                        slot="reference"
                                        class="btn btn-sekunder margin margin-left-10px">
                                        <i class="fa fa-lw fa-ellipsis-h"></i>
                                    </button>
                                </el-popover>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>

                <div 
                    class="padding padding-10-px display-flex align-center flex-end"
                    style="height: 40px;">
                    <div class="fonts fonts-10 semibold grey">Total {{ totalPages }}</div>
                    <el-pagination
                        background
                        @current-change="handleCurrentChange"
                        :current-page.sync="currentPage"
                        :page-size.sync="limit"
                        :pager-count="5"
                        layout="prev, pager, next"
                        :total.sync="totalPages">
                    </el-pagination>
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
            totalPages: 0
        }
    },
    mounted () {
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
        indexMethod(index) {
            return (index + 1) + this.offset
        },
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
            const id = this.onSearchData(this.selectedIndex).benefit_id
            const payload = {
                benefit_id: id
            }

            const rest = await axios.post('/api/benefit/delete', payload, { headers: { Authorization: token } })

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
            const url = this.formTitle === 'CREATE' ? '/api/benefit/post' : '/api/benefit/update' 

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
            const url = '/api/benefit/uploadImage' 

            let formData = new FormData();
            formData.append('benefit_id', payload.benefit_id);
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
            const url = '/api/benefit/removeImage' 

            let formData = new FormData();
            formData.append('benefit_id', payload.benefit_id);

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
            const token = 'Bearer '.concat(this.$cookies.get('token'))
            const payload = {
                limit: 2000,
                offset: 0
            }
            
            const rest = await axios.post('/api/benefit/getAll', payload, { headers: { Authorization: token } })

            if (rest && rest.status === 200) {
                const data = rest.data.data
                this.datas = data 
            }
        }
    }
}
</script>