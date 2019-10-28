//删除某行数据之后，前端的响应
myjs_afterdelete = function (data) {
	
    return true;
};
//删除某行数据前，前端的响应，返回非“”则提示报错
myjs_delevalidate = function () {

    return "";

};

//列表页面加载完成后显示数据
myjs_listPageLoad = function () {
};

//搜索按钮点击后，对传入的数据进行修正
myjs_searchClick = function (json) {
    return json;
};

//搜索结果出来后的事件
myjs_afterResultLoad = function () {

};

//保存前的动作
myjs_beforeSave = function () {
};

//保存按钮的点击后的数据修正
myjs_saveClick = function (json) {
    return json;
};

//完成保存事件后
myjs_aftersave = function (data) {
    
    return true;
};

//保存前的数据校验
myjs_savevalidate = function () {

    return "";
};

//详情页面加载完成的事件
myjs_detailPageLoad = function () {
	
};

//导入数据加载完成后
myjs_afterimportdataload = function () {
    
};