<template>
    <div>
        <Navbar login="true" signup="true"/>

        <h2 class="d-flex justify-content-center mt-2">Welcome to my home page</h2>
        <div class="m-4">
            <h4 class="d-flex justify-content-center mt-2">
                This is a Technical Assessment
            </h4>
        </div>
        <div class="m-3">
            <ul class="list-group list-group-horizontal d-flex justify-content-center mt-2">
                <router-link to="/login">
                    <li class="list-group-item">Login</li>
                </router-link>
                <router-link to="/register">
                    <li class="list-group-item">Register</li>
                </router-link>

            </ul>
        </div>
    </div>
</template>

<script>
import Navbar from './Navbar'
    export default {
        name: "Home",
        components: {Navbar},
        component: {
            Navbar
        }
    }
</script>

<style scoped>

</style>