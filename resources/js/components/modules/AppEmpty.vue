<template>
    <div 
        id="AppEmpty" 
        class="content-center padding padding-30px">
        <div class="image image-200px image-circle bg-white box-shadow" style="margin: auto;">
            <i :class="`post-center fonts fonts-64 primary ${icon ? icon : 'fa fa-3x fa-info-circle'}`"></i>
        </div>
        <div class="fonts fonts-14 semibold margin margin-top-20px">
            {{ title ? title : 'NO DATAS FOUND' }}
        </div>
    </div>
</template>
<script>
export default {
    name: 'AppEmpty',
    props: {
        icon: null,
        title: null 
    }
}
</script>