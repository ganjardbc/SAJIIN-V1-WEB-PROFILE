<template>
    <div id="App" class="width width-100">
        <AppTabs 
            :selectedIndex="selectedIndex" 
            :isScrollable="true"
            :isFull="true"
            :data="tabWedding" 
            :onChange="(data) => onChangeTabs(data)" 
            class="margin margin-bottom-15-px" />
        
        <div v-if="selectedIndex === 0">
            <div :id="`target-invitation-${guestId}`">
                <div>
                    <b class="fonts fonts-10 black">*Assalamau'alaikum warahmatullahi wabarakatuh*</b>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Kepada</span><br />
                    <b class="fonts fonts-10 black semibold">*{{ guestName }}*</b><br />
                    <b v-if="guestAddress" class="fonts fonts-10 black semibold">*{{ guestAddress }}*</b>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.</span>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Berikut link untuk info lengkap dari acara kami :</span>
                </div>
                <br />

                <div>
                    <a 
                        :href="`${initUrl}/${shortLink}/${guestId}`" 
                        target="_blank" 
                        class="fonts fonts-10"
                        style="color: blue;">
                        {{ `${initUrl}/${shortLink}/${guestId}` }}
                    </a>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.</span> 
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Dan karena acara diadakan di dalam ruangan, <b class="fonts fonts-10 black semibold">*harap tetap untuk menggunakan masker dan datang pada jam yang telah ditentukan*</b>.</span> 
                </div>
                <br />
                    
                <div>
                    <span class="fonts fonts-10 black">Kami yang berbahagia,</span><br />
                    <b class="fonts fonts-10 black semibold">*{{ title }}*</b>
                </div>
                <br />

                <div>
                    <b class="fonts fonts-10 black">*Wassalamualaikum Warahmatullahi Wabarakatuh*</b>
                </div>
                <br />

                <div v-if="tags">
                    <b class="fonts fonts-10 black semibold">*{{ tags }}*</b>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">(Simpan nomor jika link tidak dapat disentuh atau salin link ke browser untuk membuka undangan)</span> 
                </div>
            </div>
        </div>
        
        <div v-if="selectedIndex === 1">
            <div :id="`target-invitation-${guestId}`">
                <div>
                    <span class="fonts fonts-10 black">Bismillahirrahmanirrahim</span><br />
                    <span class="fonts fonts-10 black">Assalamau'alaikum warahmatullahi wabarakatuh.</span>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Dengan memohon limpahan Rahmat & Ridho Allah SWT, tanpa mengurangi rasa hormat, melalui media ini perkenankan kami mengundang <b class="fonts fonts-10 black semibold">*{{ guestName }}*</b> untuk menghadiri acara pernikahan kami,</span>
                </div>
                <br />

                <div>
                    <b class="fonts fonts-10 black semibold">*{{ brides }}*</b>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.</span> 
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Untuk info lebih lengkap terkait acara pernikahan kami, silahkan untuk membuka link undangan berikut :</span>
                </div>
                <br />

                <div>
                    <a 
                        :href="`${initUrl}/${shortLink}/${guestId}`" 
                        target="_blank" 
                        class="fonts fonts-10"
                        style="color: blue;">
                        {{ `${initUrl}/${shortLink}/${guestId}` }}
                    </a>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Terimakasih atas perhatiannya.</span>
                </div>
                <br />
                    
                <div>
                    <span class="fonts fonts-10 black">Kami yang berbahagia,</span><br />
                    <b class="fonts fonts-10 black semibold">*{{ title }}*</b>
                </div>
                <br />

                <div v-if="tags">
                    <b class="fonts fonts-10 black semibold">*{{ tags }}*</b>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">(Simpan nomor jika link tidak dapat disentuh atau salin link ke browser untuk membuka undangan)</span> 
                </div>
            </div>
        </div>

        <div v-if="selectedIndex === 2">
            <div :id="`target-invitation-${guestId}`">
                <div>
                    <span class="fonts fonts-10 black">Bismillahirrahmanirrahim</span><br />
                    <span class="fonts fonts-10 black">Assalamau'alaikum warahmatullahi wabarakatuh.</span>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Dengan memohon limpahan Rahmat & Ridho Allah SWT, tanpa mengurangi rasa hormat, melalui media ini perkenankan kami mengundang <b class="fonts fonts-10 black semibold">*{{ guestName }}*</b> untuk menghadiri acara pertunangan kami,</span>
                </div>
                <br />

                <div>
                    <b class="fonts fonts-10 black semibold">*{{ brides }}*</b>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.</span> 
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Untuk info lebih lengkap terkait acara pertunangan kami, silahkan untuk membuka link undangan berikut :</span>
                </div>
                <br />

                <div>
                    <a 
                        :href="`${initUrl}/${shortLink}/${guestId}`" 
                        target="_blank" 
                        class="fonts fonts-10"
                        style="color: blue;">
                        {{ `${initUrl}/${shortLink}/${guestId}` }}
                    </a>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Terimakasih atas perhatiannya.</span>
                </div>
                <br />
                    
                <div>
                    <span class="fonts fonts-10 black">Kami yang berbahagia,</span><br />
                    <b class="fonts fonts-10 black semibold">*{{ title }}*</b>
                </div>
                <br />

                <div v-if="tags">
                    <b class="fonts fonts-10 black semibold">*{{ tags }}*</b>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">(Simpan nomor jika link tidak dapat disentuh atau salin link ke browser untuk membuka undangan)</span> 
                </div>
            </div>
        </div>

        <div v-if="selectedIndex === 3">
            <div :id="`target-invitation-${guestId}`">
                <div>
                    <b class="fonts fonts-10 black semibold">*Kepada {{ guestName }}*</b><br />
                    <b v-if="guestAddress" class="fonts fonts-10 black semibold">*{{ guestAddress }}*</b>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Undangan ini merupakan undangan resmi dari kami,</span>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara kami :</span>
                </div>
                <br />

                <div>
                    <b class="fonts fonts-10 black semibold">*{{ brides }}*</b>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Berikut link untuk info lengkap dari acara kami :</span>
                </div>
                <br />

                <div>
                    <a 
                        :href="`${initUrl}/${shortLink}/${guestId}`" 
                        target="_blank" 
                        class="fonts fonts-10"
                        style="color: blue;">
                        {{ `${initUrl}/${shortLink}/${guestId}` }}
                    </a>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.</span> 
                </div>
                <br />

                <div>
                    <b class="fonts fonts-10 black semibold">*Terimakasih.*</b>
                </div>
                <br />
                    
                <div>
                    <span class="fonts fonts-10 black">Hormat kami,</span><br />
                    <b class="fonts fonts-10 black semibold">*{{ title }}*</b>
                </div>
                <br />

                <div v-if="tags">
                    <b class="fonts fonts-10 black semibold">*{{ tags }}*</b>
                </div>
                <br />

                <div>
                    <span class="fonts fonts-10 black">(Simpan nomor jika link tidak dapat disentuh atau salin link ke browser untuk membuka undangan)</span> 
                </div>
            </div>
        </div>

        <div style="padding-top: 15px;">
            <button 
                class="btn btn-main btn-full" 
                @click="onCopyInvitation(`target-invitation-${guestId}`, guestName)">
                <i class="icn icn-left fa fa-lg fa-copy"></i> Salin Kalimat Undangan
            </button>
            <!-- <button 
                v-if="guestPhone"
                class="btn btn-sekunder btn-full" 
                style="margin-top: 15px;"
                @click="onSendInvitation(`target-invitation-${guestId}`, guestPhone)">
                <i class="icn icn-left fab fa-lg fa-whatsapp"></i> Kirim ke WhatsApp
            </button> -->
        </div>
    </div>
</template>
<script>
import {mapActions} from 'vuex'
import AppTabs from './AppTabs'

const wedding = [
    {id: 1, label: 'Pernikahan 1', status: 'active'},
    {id: 2, label: 'Pernikahan 2', status: ''},
    {id: 3, label: 'Pertunangan', status: ''},
    {id: 4, label: 'Acara', status: ''},
]

const engagement = [
    {id: 1, label: 'Pertunangan', status: 'active'},
]

const event = [
    {id: 1, label: 'Acara', status: 'active'},
]

export default {
    name: 'App',
    data () {
        return {
            tabWedding: wedding,
            tabEngagement: engagement,
            tabEvent: event,
            selectedIndex: 0
        }
    },
    props: {
        title: null,
        brides: null,
        tags: null,
        shortLink: null,
        category: null,
        guestId: null,
        guestName: null, 
        guestAddress: null,
        guestPhone: null,
    },
    components: {
        AppTabs
    },
    methods: {
        ...mapActions({
            setToast: 'toast/setToast',
        }),
        makeToast (title) {
            const payload = {
                visible: true,
                title: title
            }
            this.setToast(payload)
        },
        onChangeTabs (data) {
            this.selectedIndex = data
        },
        onCopyInvitation(id, name) {
            var range = document.createRange()
            range.selectNode(document.getElementById(id))
            window.getSelection().removeAllRanges()
            window.getSelection().addRange(range)

            try {
                var successful = document.execCommand("copy")
                var msg = successful ? 'berhasil' : 'tidak dapat'
                this.makeToast(`Undangan ${name} ${msg} di salin`)
            } catch (err) {
                this.makeToast('Oops, undangan tidak dapat di salin')
            }

            window.getSelection().removeAllRanges()
        },
        onSendInvitation(id, phone) {
            var element = document.getElementById(id)
            var text = element.innerText
            var url = `https://wa.me/${phone}?text="${text}"`
            console.log('onSendInvitation', url)

            window.open(url, '_blank')
        },
    }
}
</script>