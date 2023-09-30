<script setup>
import {ref} from 'vue';
import {overview} from '@/Assets';
import NavLinkSidebar from '@/Components/NavLinkSidebar.vue';

const props = defineProps({
    href: String,
});

const sidebar = [
  [
    { name: "Overview", icon: overview, link: 'dashboard' },
    { name: "Blog", icon: overview, link: 'blogs' },
    { name: "Analytics", icon: overview, link: 'dashboard' },
    { name: "Schedule", icon: overview, link: 'login' },
    { name: "Payout", icon: overview, link: 'dashboard' },
    { name: "Statements", icon: overview, link: 'dashboard' },
  ],
  [
    { name: "Help", icon: overview, link: 'dashboard' },
    { name: "Community", icon: overview, link: 'dashboard' },
    { name: "Settings", icon: overview, link: 'dashboard' },
  ],
];
// console.log(route().current());

</script>

<template>
    <aside class="py-6 px-10 w-64 border-r h-screen border-gray-200 fixed overflow-y-auto">
        <img src="/images/logo.png" alt="" class="w-28" />
            <ul  v-for="group in sidebar" class="flex flex-col gap-y-6 pt-14">
                <li v-for="item in group">
                    <NavLinkSidebar :href="route(item.link)"  :active="route().current(item.link + '*')">
                        <Component :is="item.icon" class="w-6 h-6 fill-current" />
                        <span>{{ item.name }}</span>
                    </NavLinkSidebar>
                </li>
            </ul>
    </aside>
</template>