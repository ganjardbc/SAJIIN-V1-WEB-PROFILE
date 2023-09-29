import Admin from '../components/layouts/Admin.vue';
import NotFoundWeb from '../components/web/404.vue';
import Dashboard from '../components/admin/Index.vue';
import Profile from '../components/admin/profile/Index.vue';
import Bizpar from '../components/admin/bizpar/Index.vue';
import Category from '../components/admin/category/Index.vue';
import Article from '../components/admin/article/Index.vue';
import Feedback from '../components/admin/feedback/Index.vue';
import Benefit from '../components/admin/benefit/Index.vue';
import Role from '../components/admin/role/Index.vue';
import User from '../components/admin/user/Index.vue';
import Permission from '../components/admin/permission/Index.vue';

const routes = {
    path: '/admin',
    component: Admin,
    children: [
        {
            name: 'dashboard',
            path: '/dashboard',
            component: Dashboard
        },
        {
            name: 'profile',
            path: '/admin-profile',
            component: Profile
        },

        // admin
        {
            name: 'bizpar',
            path: '/admin-bizpar',
            component: Bizpar
        },
        {
            name: 'category',
            path: '/admin-category',
            component: Category
        },
        {
            name: 'article',
            path: '/admin-article',
            component: Article
        },
        {
            name: 'feedback',
            path: '/admin-feedback',
            component: Feedback
        },
        {
            name: 'benefit',
            path: '/admin-benefit',
            component: Benefit
        },
        {
            name: 'role',
            path: '/admin-role',
            component: Role
        },
        {
            name: 'permission',
            path: '/admin-permission',
            component: Permission
        },
        {
            name: 'user',
            path: '/admin-user',
            component: User
        },

        // info
        {
            name: '404',
            path: '/admin-not-found',
            component: NotFoundWeb
        }
    ]
}

export default routes