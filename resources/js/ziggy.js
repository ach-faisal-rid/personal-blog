const Ziggy = {
    url: "http://localhost:8000",
    port: 8000,
    defaults: {},
    routes: {
        "filament.exports.download": {
            uri: "filament/exports/{export}/download",
            methods: ["GET", "HEAD"],
            parameters: ["export"],
            bindings: { export: "id" },
        },
        "filament.imports.failed-rows.download": {
            uri: "filament/imports/{import}/failed-rows/download",
            methods: ["GET", "HEAD"],
            parameters: ["import"],
            bindings: { import: "id" },
        },
        "filament.admin.auth.login": {
            uri: "admin/login",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.auth.logout": {
            uri: "admin/logout",
            methods: ["POST"],
        },
        "filament.admin.pages.dashboard": {
            uri: "admin",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.categories.index": {
            uri: "admin/categories",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.categories.create": {
            uri: "admin/categories/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.categories.edit": {
            uri: "admin/categories/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.comments.index": {
            uri: "admin/comments",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.comments.create": {
            uri: "admin/comments/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.comments.edit": {
            uri: "admin/comments/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.post-categories.index": {
            uri: "admin/post-categories",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.post-categories.create": {
            uri: "admin/post-categories/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.post-categories.edit": {
            uri: "admin/post-categories/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.posts.index": {
            uri: "admin/posts",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.posts.create": {
            uri: "admin/posts/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.posts.edit": {
            uri: "admin/posts/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.post-thumbnails.index": {
            uri: "admin/post-thumbnails",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.post-thumbnails.create": {
            uri: "admin/post-thumbnails/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.post-thumbnails.edit": {
            uri: "admin/post-thumbnails/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.post-users.index": {
            uri: "admin/post-users",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.post-users.create": {
            uri: "admin/post-users/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.post-users.edit": {
            uri: "admin/post-users/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.roles.index": {
            uri: "admin/roles",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.roles.create": {
            uri: "admin/roles/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.roles.edit": {
            uri: "admin/roles/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.role-users.index": {
            uri: "admin/role-users",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.role-users.create": {
            uri: "admin/role-users/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.role-users.edit": {
            uri: "admin/role-users/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.thumbnails.index": {
            uri: "admin/thumbnails",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.thumbnails.create": {
            uri: "admin/thumbnails/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.thumbnails.edit": {
            uri: "admin/thumbnails/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.users.index": {
            uri: "admin/users",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.users.create": {
            uri: "admin/users/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.users.view": {
            uri: "admin/users/{record}",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.users.edit": {
            uri: "admin/users/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        login: { uri: "login", methods: ["GET", "HEAD"] },
        "login.store": { uri: "login", methods: ["POST"] },
        logout: { uri: "logout", methods: ["POST"] },
        "password.request": {
            uri: "forgot-password",
            methods: ["GET", "HEAD"],
        },
        "password.reset": {
            uri: "reset-password/{token}",
            methods: ["GET", "HEAD"],
            parameters: ["token"],
        },
        "password.email": { uri: "forgot-password", methods: ["POST"] },
        "password.update": { uri: "reset-password", methods: ["POST"] },
        register: { uri: "register", methods: ["GET", "HEAD"] },
        "register.store": { uri: "register", methods: ["POST"] },
        "user-profile-information.update": {
            uri: "user/profile-information",
            methods: ["PUT"],
        },
        "user-password.update": { uri: "user/password", methods: ["PUT"] },
        "password.confirm": {
            uri: "user/confirm-password",
            methods: ["GET", "HEAD"],
        },
        "password.confirmation": {
            uri: "user/confirmed-password-status",
            methods: ["GET", "HEAD"],
        },
        "password.confirm.store": {
            uri: "user/confirm-password",
            methods: ["POST"],
        },
        "two-factor.login": {
            uri: "two-factor-challenge",
            methods: ["GET", "HEAD"],
        },
        "two-factor.login.store": {
            uri: "two-factor-challenge",
            methods: ["POST"],
        },
        "two-factor.enable": {
            uri: "user/two-factor-authentication",
            methods: ["POST"],
        },
        "two-factor.confirm": {
            uri: "user/confirmed-two-factor-authentication",
            methods: ["POST"],
        },
        "two-factor.disable": {
            uri: "user/two-factor-authentication",
            methods: ["DELETE"],
        },
        "two-factor.qr-code": {
            uri: "user/two-factor-qr-code",
            methods: ["GET", "HEAD"],
        },
        "two-factor.secret-key": {
            uri: "user/two-factor-secret-key",
            methods: ["GET", "HEAD"],
        },
        "two-factor.recovery-codes": {
            uri: "user/two-factor-recovery-codes",
            methods: ["GET", "HEAD"],
        },
        "profile.show": { uri: "user/profile", methods: ["GET", "HEAD"] },
        "other-browser-sessions.destroy": {
            uri: "user/other-browser-sessions",
            methods: ["DELETE"],
        },
        "current-user-photo.destroy": {
            uri: "user/profile-photo",
            methods: ["DELETE"],
        },
        "current-user.destroy": { uri: "user", methods: ["DELETE"] },
        "sanctum.csrf-cookie": {
            uri: "sanctum/csrf-cookie",
            methods: ["GET", "HEAD"],
        },
        "livewire.update": { uri: "livewire/update", methods: ["POST"] },
        "livewire.upload-file": {
            uri: "livewire/upload-file",
            methods: ["POST"],
        },
        "livewire.preview-file": {
            uri: "livewire/preview-file/{filename}",
            methods: ["GET", "HEAD"],
            parameters: ["filename"],
        },
        "ignition.healthCheck": {
            uri: "_ignition/health-check",
            methods: ["GET", "HEAD"],
        },
        "ignition.executeSolution": {
            uri: "_ignition/execute-solution",
            methods: ["POST"],
        },
        "ignition.updateConfig": {
            uri: "_ignition/update-config",
            methods: ["POST"],
        },
        home: { uri: "/", methods: ["GET", "HEAD"] },
        "posts.index": { uri: "posts", methods: ["GET", "HEAD"] },
        "posts.show": {
            uri: "post/{id}",
            methods: ["GET", "HEAD"],
            parameters: ["id"],
        },
        "thumbnail.index": { uri: "thumbnails", methods: ["GET", "HEAD"] },
        "thumbnail.show": {
            uri: "thumbnail/{id}",
            methods: ["GET", "HEAD"],
            parameters: ["id"],
        },
        dashboard: { uri: "dashboard", methods: ["GET", "HEAD"] },
        404: {
            uri: "{any}",
            methods: ["GET", "HEAD"],
            wheres: { any: ".*" },
            parameters: ["any"],
        },
    },
};
if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
