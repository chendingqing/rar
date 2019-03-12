// pages/order/order.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    listId: "0000000000004",
    amount: 1,
    state: 0, /*0为未收款状态; 1,2为购买的待发货和已发货状态; 3,4为免费的待发货和已发货状态;5为确认收货后已完结状态*/
    carId: "A888888",
    userName: "",
    phoneNum: "",
    site: "",
    address: "",
    test1: 1,
    test2: 2,
    test3: 3,
    test4: 4,
    test5: 5,
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function() {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function() {

  },
/*确认收货与取消订单*/
  affirm: function() {
    var that = this;
    wx.showModal({
      title: "确认收货",
      content: "是否确认收货",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "收货成功！",
          })
          that.setData({
            state: 5
          })
        }
      }
    })
  },
  cancellation: function() {
    wx.showModal({
      title: "取消订单",
      content: "是否取消订单？",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "订单已取消！"
          })
        }
      }
    })
  },
  affirmTest1: function() {
    var that = this;
    wx.showModal({
      title: "确认收货",
      content: "是否确认收货",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "收货成功！",
          })
          that.setData({
            test1: 5
          })
        }
      }
    })

  },
  //测试订单其他状态
  cancellationTest1: function() {
    wx.showModal({
      title: "取消订单",
      content: "是否取消订单？",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "订单已取消！"
          })
        }
      }
    })
  },
  affirmTest2: function() {
    var that = this;
    wx.showModal({
      title: "确认收货",
      content: "是否确认收货",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "收货成功！",
          })
          that.setData({
            test2: 5
          })
        }
      }
    })
  },
  cancellationTest2: function() {
    wx.showModal({
      title: "取消订单",
      content: "是否取消订单？",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "订单已取消！"
          })
        }
      }
    })
  },
  affirmTest3: function() {
    var that = this;
    wx.showModal({
      title: "确认收货",
      content: "是否确认收货",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "收货成功！",
          })
          that.setData({
            test3: 5
          })
        }
      }
    })
  },
  cancellationTest3: function() {
    wx.showModal({
      title: "取消订单",
      content: "是否取消订单？",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "订单已取消！"
          })
        }
      }
    })
  },
  affirmTest4: function() {
    var that = this;
    wx.showModal({
      title: "确认收货",
      content: "是否确认收货",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "收货成功！",
          })
          that.setData({
            test4: 5
          })
        }
      }
    })
  },
  cancellationTest4: function() {
    wx.showModal({
      title: "取消订单",
      content: "是否取消订单？",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "订单已取消！"
          })
        }
      }
    })
  },
  affirmTest5: function() {
    var that = this;
    wx.showModal({
      title: "确认收货",
      content: "是否确认收货",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "收货成功！",
          })
          that.setData({
            test5: 5
          })
        }
      }
    })
  },
  cancellationTest5: function() {
    wx.showModal({
      title: "取消订单",
      content: "是否取消订单？",
      success(res) {
        if (res.confirm) {
          wx.showToast({
            title: "订单已取消！"
          })
        }
      }
    })
  },
  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function() {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function() {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function() {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function() {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function() {

  }
})