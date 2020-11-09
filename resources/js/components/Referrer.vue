<template>
    <h4>Loading.....</h4>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "Referrer",
        created() {
            localStorage.setItem('refer', JSON.stringify(this.$route.query.ref))
            this.$router.push('/register')
            // axios.get(`http://localhost:8000/api/auth/referer?ref=${this.$route.query.ref}`).then((res) => {
            //     const {status} = res;
            //     if (status === 200) {
            //         this.$router.push('/register')
            //     }
            // })
        }
    }
</script>

<style scoped>

</style>