// pages/repair_car/repair_car.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    repairCarImg:"../images/carhome/pic3.png",
    repairCartTitle:"光明4S店修车厂",
    repairCarText:"二手车高价回收，好车便宜卖，快来买,价格实惠有保障噢！！！！二手车高价回收，好车便宜卖，快来买,价格实惠有保障！",
    repairCarAddressText:"重庆市彭水县下坝街58号"
  },
  callphone: function () {
    wx.makePhoneCall({
      phoneNumber: '66666666' //仅为示例，并非真实的电话号码
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