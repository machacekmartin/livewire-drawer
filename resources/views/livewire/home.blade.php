<div class="flex justify-center items-center h-screen">
    <button class="px-4 py-2 text-sm text-white bg-gray-900 rounded-md border border-gray-100 cursor-pointer" type="button" x-on:click="$dispatch('open-drawer', {
        component: 'components.drawers.image-detail',
        props: {

        }
    })">Open file details</button>
</div>