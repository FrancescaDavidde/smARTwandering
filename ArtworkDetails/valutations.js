var val = new Vue({
    el: '#val1',
    data: {
        val: valutations,
        vote: mark
    },
    methods: {
        incrementVal: function () {
            this.val += 1
        } ,
        updateMark: function(mark) {
            this.vote = Math.ceil((this.vote + mark) / 2)
        }
    }
})