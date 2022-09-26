// eslint-disable-next-line import/no-mutable-exports
let $axios;

export function initializeAxios(axiosInstance) {
    $axios = axiosInstance;
}

export const handlerResponse = (res) => res.data;

export const handlerResponseTreeArray = (res) => res.data[0];

export const handlerResponseWithItems = (res) => {
    const _res = handlerResponse(res);

    let { items } = _res;

    if (!items) {
        items = [];
    } else if (!Array.isArray(items) && typeof items === 'object') {
        items = Object.values(items);
        // TODO: добавить обработчик ошибок
    } else if (!Array.isArray(items)) {
        throw new TypeError('items not array: ' + items);
        // TODO: добавить обработчик ошибок
    }
    return {
        items,
        meta: _res.meta,
    };
};

export const getErrorMessage = async(error) => {
    if (error?.response && error?.response?.exception) {
        const exception = error.response.exception;

        return exception.message;
    }

    if (error?.response?.data?.exception?.message) {
        return error.response.data.exception.message;
    }

    if (error?.response && error?.response?.data?.errors) {
        const errors = error.response.data.errors;

        if (Array.isArray(errors)) {
            return errors.map((e) => e.title);
        }
        return errors.title;
    }

    if (
        error?.request?.responseType === 'blob' &&
        error?.response?.data instanceof Blob
    ) {
        const data = await error.response.data.text();

        return JSON.parse(data)?.errors?.title;
    }

    return error.message;
};

export {
    $axios,
};
