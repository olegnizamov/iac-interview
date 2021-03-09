BX.ready(function () {
    /** Подключаем обработчик на событие показа формы */

    /** Подключаем только на странице stream */
    let currentUrl = window.location.pathname;
    if (currentUrl.indexOf('/stream/') == -1) return;

    BX.addCustomEvent("OnShowLHE", function (command, params) {

        /** Подключаем только для формы blogPostForm */
        if (!BX("divoPostFormLHE_blogPostForm")) return;

        /** Подключаем только один раз */
        if (BX("POST_PUBLISH_DATE")) return;

        let publishDate = BX.create('div', {
            html: '<div style="padding: 20px 0px 7px 15px;"> ' +
                ' Время публикации ' +
                '<input id="POST_PUBLISH_DATE" name="POST_PUBLISH_DATE" type="datetime-local">' +
                '<input id="DATE_PUBLISH_DEF" name="DATE_PUBLISH_DEF" type="text" hidden="hidden">' +
                '</div>'
        });
        BX.append(publishDate, BX('divoPostFormLHE_blogPostForm'));

        BX.bind(BX("POST_PUBLISH_DATE"), "change", function (e) {
            if (BX("POST_PUBLISH_DATE").value) {
                let publishDate = new Date(Date.parse(BX("POST_PUBLISH_DATE").value));
                let now = new Date();
                let diffDays = Math.floor((publishDate - now) / (1000 * 60 * 60 * 24));
                if(diffDays<0) return;


                let month = publishDate.getMonth() + 1;
                BX("DATE_PUBLISH_DEF").value = publishDate.getDate() + '.'
                    + (month < 10 ? '0' : '') + month + '.'
                    + publishDate.getFullYear() + ' '
                    + (publishDate.getHours() < 10 ? '0' : '') + publishDate.getHours() + ':'
                    + (publishDate.getMinutes() < 10 ? '0' : '') + publishDate.getMinutes() + ':00';

                window["submitBlogPostForm"] = BX.proxy(function (editor, value) {
                    BX.submit(BX('blogPostForm'), 'draft');
                }, this);
            }
        });
    });
});