import {Route} from "@/Composables/useRoutes";
import {router} from "@inertiajs/vue3";

export function useLogout(route: Route): void {
    router.visit(
        route.link,
        {
            method: 'post',
        });
}
