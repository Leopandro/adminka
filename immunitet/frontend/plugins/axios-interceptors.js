import {
    NotificationType,
} from '~/types/notifications.js';
import {
    getErrorMessage,
} from '@/shared/utils/api';

/**
 * Пути запросов, которые исключаются из перехвата ошибок
 * @type {string[]}
 */
const excludedPaths = ['/api/user/profile'];

export default function({ $axios, app }) {
    const didAbort = (error) => $axios.isCancel(error);
    const getCancelSource = () => $axios.CancelToken.source();

    $axios.onRequest((config) => {
        const abort = config?.abort;

        if (typeof abort === 'function') {
            const { cancel, token } = getCancelSource();

            config.cancelToken = token;
            abort(cancel);
        }

        return config;
    });

    $axios.onError(async(error) => {
        if (didAbort(error)) {
            error.aborted = true;
            error.message = 'Operation canceled by user';
            return Promise.reject(error);
        }
        const urlRequest = error?.config?.url || error?.request?.responseURL;
        const isInExcludedPaths = excludedPaths.some((path) => urlRequest.includes?.(path));

        if (isInExcludedPaths) {
            return;
        }
        const codeError = parseInt(error.response && error.response.status);
        const errorNotification = {
            codeError,
            message: await getErrorMessage(error),
            type: NotificationType.ERROR,
            pathRequest: urlRequest,
        };

        const code = error?.response.data?.errors?.code;
        const codeSessionEnd = 5;

        if (codeError === 401) {
            await app.$auth.logout();

            if (code === codeSessionEnd) {
                app.router.push({
                    path: '/login',
                }, () => {
                    app.store.dispatch('notifications/addItem', {
                        ...errorNotification,
                        codeType: codeSessionEnd,
                    });
                });
            } else {
                app.router.push({
                    path: '/login',
                });
            }

            // if (items.find((elem) => elem.codeType === codeSessionEnd)) {
            //     return;
            // }
        }

        throw error;
    });
}
