# Dida\Container 组件库

`Dida\Container` 是一个容器类，可以为App提供懒加载、依赖注入和服务定位功能。它是 [宙品科技](http://zeupin.com) 开源的 [Dida框架](http://dida.zeupin.com) 的一个功能组件库。

* Home <https://github.com/zeupin/dida-container>
* Wiki <https://github.com/zeupin/dida-container/wiki>

## 支持三种服务类型

- 类名 -- `CLASSNAME_TYPE`
- 闭包函数 -- `CLOSURE_TYPE`
- 服务实例 -- `INSTANCE_TYPE`

> 本质上，每一个服务条目都是一个对象实例。

## API

- `has($id)` -- 是否存在某个服务
- `set($id, $service)` -- 设置一个服务
- `setSingleton($id, $service)` -- 设置一个单例服务
- `get($id)` -- 取回一个服务实例
- `getNew($id)` -- 取回一个新的服务实例（不可用于Singleton服务，否则会抛出一个异常）
- `remove($id)` -- 删除一个服务
- `keys()` -- 获取所有已注册的服务id

## 作者

* [Macc Liu](https://github.com/maccliu)

## 感谢

* [宙品科技，Zeupin LLC](http://zeupin.com) , 尤其是 [Dida 框架团队](http://dida.zeupin.com)

## 版权声明

版权所有 (c) 2017-2018 上海宙品信息科技有限公司。<br>Copyright (c) 2017-2018 Zeupin LLC. <http://zeupin.com>

源代码采用MIT授权协议。<br>Licensed under The MIT License.

如需在您的项目中使用，必须保留本源代码中的完整版权声明。<br>Redistributions of files MUST retain the above copyright notice.
