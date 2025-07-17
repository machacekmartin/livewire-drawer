export default () => ({
    opened: false,
    scroll: 0,

    open(component, props) {
        if (this.opened) return;

        this.scroll = document.documentElement.scrollTop;

        document.body.classList.add('fixed');
        document.body.classList.add('overflow-y-scroll');
        document.body.classList.add('w-full');

        document.body.style.top = -this.scroll + 'px';

        this.opened = true;
    },

    close() {
        if (!this.opened) return;

        document.body.classList.remove('fixed');
        document.body.classList.remove('overflow-y-scroll');
        document.body.classList.remove('w-full');

        document.body.style.top = '0px';
        window.scrollTo(0, this.scroll);

        this.opened = false;

        setTimeout(() => this.$wire.unmountComponent(), 400);

        this.$dispatch('refocus');
    }
});
