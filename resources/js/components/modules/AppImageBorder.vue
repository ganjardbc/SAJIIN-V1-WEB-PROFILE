<template>
    <div 
        id="App" 
        :class="`${theme} ${enableSizeMobile ? 'size-mobile' : ''}`" 
        :style="`
            width: ${customWidth ? customWidth : ''}; 
            transform: scaleX(${scaleX ? scaleX : '-1'});
        `">
        <img :src="border" alt="">
    </div>
</template>
<script>

export default {
    name: 'App',
    data () {
        return {
            theme: 'theme-border',
            border: ''
        }
    },
    mounted () {
        const dt = this.position
        switch (dt) {
            case 'top-left':
                this.border = this.customImageTopLeft ? this.customImageTopLeft : '/images/green-cover-top-left.png'
                this.theme = 'theme-border top-left'
                break;
            case 'top-right':
                this.border = this.customImageTopRight ? this.customImageTopRight : '/images/green-cover-top-left.png'
                this.theme = 'theme-border top-right'
                break;
            case 'bottom-left':
                this.border = this.customImageBottomLeft ? this.customImageBottomLeft : '/images/green-cover-bottom-right.png'
                this.theme = 'theme-border bottom-left'
                break;
            case 'bottom-right':
                this.border = this.customImageBottomRight ? this.customImageBottomRight : '/images/green-cover-bottom-right.png'
                this.theme = 'theme-border bottom-right'
                break;
            default:
                this.border = this.customImageTopLeft ? this.customImageTopLeft : '/images/green-cover-top-left.png'
                this.theme = 'theme-border top-left'
                break;
        }
    },
    props: {
        position: {
            type: String,
            required: false 
        },
        scaleX: {
            default: null,
        },
        customWidth: {
            default: null,
        },
        customImageTopLeft: {
            default: null,
        },
        customImageTopRight: {
            default: null,
        },
        customImageBottomLeft: {
            default: null,
        },
        customImageBottomRight: {
            default: null,
        },
        enableSizeMobile: {
            default: null,
        }
    }
}
</script>