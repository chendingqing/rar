// pages/account/account.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    array: ['渝','京', '津', '沪', '蒙','新','藏','宁','桂','港','澳','黑','吉','辽','晋','冀','青','鲁','豫','苏','皖','浙','闽','赣','湘','鄂','粤','琼','甘','陕','黔','贵','滇','云','川'],
    index: 0,
    carId:"A88888",
    name:'张青',
    phone:'15285987845',
    region: ["上海市", "上海市", "黄浦区"],
    site_det:"南京西路800弄159号201室",
    moneyNum:30
  },
// 选择省市区函数
  changeRegin: function (e) {
    console.log('e');
    // console.log(e.detail.value);
    this.setData({
      region: e.detail.value
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})