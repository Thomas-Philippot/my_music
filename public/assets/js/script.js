$(document)
    .one('ready', function () {
        console.info('Heyy !! it works')
    })
    .one('focus.autoExpand', 'textarea.autoExpand', function(){
        var savedValue = this.value;
        this.value = '';
        this.baseScrollHeight = this.scrollHeight;
        this.value = savedValue;
    })
    .on('input.autoExpand', 'textarea.autoExpand', function(){
        var minRows = this.getAttribute('data-min-rows')|0, rows;
        this.rows = minRows;
        rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 16);
        this.rows = minRows + rows;
    });


$(document).ready(function(){
    $('.sidenav').sidenav();

    $('select').formSelect();

    $('img.avatar').on('click', function (event) {
        console.info(event.currentTarget);

        let images = $('img.avatar');
        for (let image of images) {
            image.setAttribute('class', 'regular')
        }
        let img = event.currentTarget;
        img.setAttribute('class', 'avatar grow');
    })
});