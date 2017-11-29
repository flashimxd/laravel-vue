export default class {

    constructor(include = null){
        this.pagination = {
            current_page: 0,
            per_page: 0,
            total:0
        };
        this.search = '';
        this.order= {
            key: 'id',
            sort: 'asc'
        };
        this.include = include;
    }

    set pagination(page){
        page.current_page--;
        this._pagination = page;
    }

    get pagination(){
        return this._pagination;
    }

    createOptions(){
        let options = {
            page: this.pagination.current_page + 1,
            orderBy: this.order.key,
            sortedBy: this.order.sort,
            search: this.search
        }

        if(this.include){
            options.include = this.include;
        }

        return options;
    }
}